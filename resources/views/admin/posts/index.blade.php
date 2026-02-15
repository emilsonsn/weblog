@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="card-title float-start">Lista de Posts</h6>
            <div class="card-title float-end btn btn-primary btn-sm">
                <a href="{{ route('admin.posts.create') }}" class="text-white">Adicionar Novo</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Título</th>
                            <th>Thumbnail</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th>Criado Por</th>
                            <th>Destaque</th>
                            <th>Criado em</th>
                            <th style="width: 40px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <img src="{{ $post->thumbnail ? asset('storage/uploads/posts/' . $post->thumbnail) : asset('images/placeholder-post.png') }}"
                                        style="width: 50px; height: 50px">
                                </td>
                                <td>{{ $post->category->title }}</td>
                                <td>{{ Str::limit(strip_tags($post->body), 40) }}</td>
                                <td>{{ optional($post->user)->name }}</td>
                                <td>{{ $post->is_highlighted ? 'Sim' : 'Não' }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}">
                                        <span class="badge bg-primary">Editar</span>
                                    </a>
                                    <form id="delete-form-{{ $post->id }}" method="post"
                                        action="{{ route('admin.posts.destroy', $post->id) }}" style="display: none">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <a href="javascript:void(0)" class="badge bg-danger text-white"
                                        onclick="
                                    if(confirm('Tem certeza que deseja excluir?'))
                                    {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $post->id }}').submit();
                                    }">Excluir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="9" class="text-center">Nenhum registro encontrado!</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
