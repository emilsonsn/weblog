@extends('layouts.master')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <h6 class="card-title">Edit Post #{{ $post->id }}</h6>
    </div>

    <form role="form" method="post" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">

            @php
                $pt = $post->translations->where('locale','pt')->first();
                $en = $post->translations->where('locale','en')->first();
            @endphp

            <ul class="nav nav-tabs mb-3">
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
                        <input type="text" name="title_pt" class="form-control" value="{{ old('title_pt', $pt->title ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label>Descrição (PT)</label>
                        <textarea class="form-control summernote" name="body_pt">{{ old('body_pt', $pt->body ?? '') }}</textarea>
                    </div>
                </div>

                <div class="tab-pane fade" id="en">
                    <div class="mb-3">
                        <label>Title (EN)</label>
                        <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $en->title ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label>Description (EN)</label>
                        <textarea class="form-control summernote" name="body_en">{{ old('body_en', $en->body ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category" class="form-control @error('category') is-invalid @enderror">
                    <option>Select Once</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Destaque?</label><br>
                <input type="checkbox" class="form-check-input" name="is_highlighted" value="1" {{ $post->is_highlighted ? 'checked' : '' }}>
            </div>

            <div class="mb-3">
                <label>Tag</label>
                <select class="form-control js-tags" name="tags[]" multiple="multiple">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag }}"
                            {{ in_array($tag, $post->tags()->pluck('title')->toArray()) ? 'selected' : '' }}>
                            {{ $tag }}
                        </option>
                    @endforeach
                </select>
            </div>

            <img src="{{ url('storage/uploads/posts/'.$post->thumbnail) }}" id="image-preview" style="max-height: 150px;">

            <div class="mb-3">
                <label>Upload Thumbnail</label>
                <input type="file" class="form-control" name="thumbnail" id="thumbnail">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
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
    height: 180
});

$('#thumbnail').change(function() {
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
