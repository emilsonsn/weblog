<div class="card-body">
    <div class="mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
               id="title" placeholder="Enter Name">
        @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="title">Category</label>
        <select name="category" class="form-control">
            <option selected>Select Once</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
        @error('title')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="summernote">Description</label>
        <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                  name="description" id="summernote" placeholder="Enter Description"></textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="tags">Tag</label>
        <select class="form-control js-tags @error('tags') is-invalid @enderror" name="tags[]" multiple="multiple">
            @foreach($tags as $tag)
                <option value="{{ $tag }}">{{ $tag }}</option>
            @endforeach
        </select>
        @error('tags')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="is_highlighted">Destaque?</label>
        <input type="checkbox" class="form-check-input @error('is_highlighted') is-invalid @enderror" name="is_highlighted"
               id="is_highlighted" value="1" {{ $post->is_highlighted ? 'checked' : '' }}>
        @error('is_highlighted')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>

    <img src="" id="image-preview" style="max-height: 150px;">
    <div class="mb-3">
        <label for="image">Upload Image</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
               id="image">
        @error('image')
        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
        @enderror
    </div>

</div>
