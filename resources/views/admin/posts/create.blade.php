@extends('layouts.master')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <h6 class="card-title">Add New Post</h6>
    </div>

    <form role="form" method="post" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            <ul class="nav nav-tabs mb-3" id="langTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pt" type="button">Português</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#en" type="button">English</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="pt">
                    <div class="mb-3">
                        <label>Título (PT)</label>
                        <input type="text" value="{{ old('title_pt') }}" class="form-control" name="title_pt" placeholder="Digite o título em português">
                    </div>

                    <div class="mb-3">
                        <label>Descrição (PT)</label>
                        <textarea class="form-control summernote" name="body_pt">{{ old('body_pt') }}</textarea>
                    </div>
                </div>

                <div class="tab-pane fade" id="en">
                    <div class="mb-3">
                        <label>Title (EN)</label>
                        <input type="text" value="{{ old('title_en') }}" class="form-control" name="title_en" placeholder="Enter title in English">
                    </div>

                    <div class="mb-3">
                        <label>Description (EN)</label>
                        <textarea class="form-control summernote" name="body_en">{{ old('body_en') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category" class="form-control @error('category') is-invalid @enderror">
                    <option value="">Select Once</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="is_highlighted">Destaque?</label><br>
                <input type="checkbox" class="form-check-input @error('is_highlighted') is-invalid @enderror"
                       name="is_highlighted" id="is_highlighted" value="1" {{ old('is_highlighted') ? 'checked' : '' }}>
                @error('is_highlighted')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Tag</label>
                <select class="form-control js-tags @error('tags') is-invalid @enderror" name="tags[]" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{ $tag }}" {{ in_array($tag, old('tags', [])) ? 'selected' : '' }}>
                            {{ $tag }}
                        </option>
                    @endforeach
                </select>
                @error('tags')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <img src="" id="image-preview" style="max-height: 150px;">

            <div class="mb-3">
                <label>Upload Thumbnail</label>
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" id="thumbnail">
                @error('thumbnail')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('.summernote').summernote({
    tabsize: 2,
    height: 180,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview']]
    ]
});

$('#thumbnail').change(function () {
    let reader = new FileReader();
    reader.onload = (e) => {
        $('#image-preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0])
});

$(".js-tags").select2({
    tags: true
});
</script>
@endsection
