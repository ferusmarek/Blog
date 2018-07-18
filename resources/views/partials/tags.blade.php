@if ($post->tags)

    <p class="tags">
        @foreach ($post->tags as $tag)
            <a href="{{ url('tag', $tag->tag)}}" class="btn btn-warning btn-xs">
                <small>{{ $tag->tag }}</small>
            </a>

        @endforeach
    </p>

@endif
