@extends('master')
@section('title', isset($title)? $title : "All post")

@section('content')
    <div class="container">
    @if(isset($data))
        <h2 class="box-heading text-muted">Instagram gallery Gallery</h2>
        <p>Little bit of the instagram gallery for you mate</p>
        <div class="row">
            @foreach( $data->data as $links)
                <div class="col-md-4">
                    <div class="thumbnail">
                        <a href="{{url($links->link)}}">
                            <img src="{{url($links->images->thumbnail->url)}}" class="img-thumbnail" alt="insta_pic">
                        </a>
                    </div>
                </div>
        </div>
            @endforeach
            @endif
    </div>

    <section class="box post-list">
        <h1 class="box-heading text-muted">
{{ $title or 'this is a blog' }}
            </h1>

        @forelse ($posts as $post)
            <article id="post-{{ $post->id }}" class="post">
                <header class="post-header">
                    <h2>
                        <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>

                        <time datetime="{{ $post->datetime }}">
                            <small>{{ $post->created_at }}</small>
                        </time>
                    </h2>
                    @include('partials.tags')

                </header>
                <div class="post-content">
                    <p>
                        {{ $post->teaser}}
                    </p>

                </div>
                <footer class="post-footer">
                    <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>

                </footer>

            </article>

        @empty
            <p>"Nothing news!!!!"</p>
        @endforelse
    </section>

@endsection
