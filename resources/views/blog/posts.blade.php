@if ($highlightedPosts->count() > 0)
<div class="mb-5">
    <div id="featuredPostsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            @foreach ($highlightedPosts as $index => $post)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="card bg-black text-light border-0 shadow-lg overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('singlePost', $post->id) }}">
                                    <img src="{{ $post->thumbnail ? asset('storage/uploads/posts/' . $post->thumbnail) : asset('images/placeholder-post.png') }}"
                                         class="w-100 h-100" style="object-fit: cover; min-height: 220px;">
                                </a>
                            </div>
                            <div class="col-md-8 position-relative">
                                <div class="card-body p-4">
                                    <span class="badge bg-warning text-dark mb-3">Destaque</span>
                                    <h3 class="fw-bold">
                                        <a href="{{ route('singlePost', $post->id) }}" class="text-decoration-none text-light">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="text-secondary mb-4">
                                        {{ Str::limit(strip_tags($post->body), 140) }}
                                    </p>
                                    <a href="{{ route('singlePost', $post->id) }}" class="btn btn-outline-warning">
                                        Ler destaque
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#featuredPostsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredPostsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>
@endif


<div class="row">
    <h4 class="text-white">Últimos Artigos:</h4>

    @foreach ($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-light border-0 shadow h-100">
                <a href="{{ route('singlePost', $post->id) }}">
                    <img class="card-img-top"
                        src="{{ $post->thumbnail ? asset('storage/uploads/posts/' . $post->thumbnail) : asset('images/placeholder-post.png') }}"
                        alt="{{ $post->title }}" style="height: 220px; object-fit: cover;">
                </a>
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('singlePost', $post->id) }}" class="text-decoration-none text-light">
                        <h5 class="card-title fw-bold mb-2">{{ $post->title }}</h5>
                    </a>
                    <div class="mb-2 small text-secondary">
                        Por <span class="text-light">{{ optional($post->user)->name }}</span>
                        • {{ $post->created_at->format('d/m/Y') }}
                    </div>
                    <p class="card-text text-secondary flex-grow-1">
                        {{ Str::limit(strip_tags($post->body), 90) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('singlePost', $post->id) }}" class="btn btn-primary btn-sm">
                            Ler mais
                        </a>

                        <div class="card-footer bg-transparent border-0 text-end small text-secondary">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
