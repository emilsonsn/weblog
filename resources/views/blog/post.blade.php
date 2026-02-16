@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <article class="bg-dark text-light rounded-4 shadow-lg overflow-hidden">

                @if ($post->thumbnail)
                    <img src="{{ '/storage/uploads/posts/' . $post->thumbnail }}"
                        class="w-100" style="max-height:420px; object-fit:cover;">
                @endif

                <div class="p-4 p-md-5">

                    <h1 class="fw-bold mb-3">{{ $post->translation()->title }}</h1>

                    <div class="d-flex flex-wrap gap-2 small text-secondary mb-4">
                        <span>Por <strong class="text-light">{{ optional($post->user)->name }}</strong></span>
                        <span>•</span>
                        <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
                        <span>•</span>
                        <span>Categoria:
                            <a href="{{ route('category.posts',  ['id' => $post->category_id, 'locale' => locale()]) }}" class="text-decoration-none text-info">
                                {{ optional($post->category)->title }}
                            </a>
                        </span>
                    </div>

                    @if ($post->tags->count() > 0)
                        <div class="mb-4">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('tag.posts', $tag->id) }}"
                                   class="badge bg-secondary text-decoration-none me-1">
                                    #{{ $tag->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="post-body fs-5 lh-lg">
                        {!! $post->translation()->body !!}
                    </div>
                </div>
            </article>

        </div>
    </div>
</div>
@endsection
