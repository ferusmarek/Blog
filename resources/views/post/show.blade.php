@extends('master')
@section('title', $post->title)



@section('content')

	<section class="box">
		<article class="post full-post">
			@include('flash::message')

			<header class="post-header">
				@if(!($post->cover == 'NULL'))
						<div class="coverimg" style="background-image:url({{asset('coverimg/posts/'.$post->id.'/'.$post->cover)}})"></div>
				@endif
				<h1 class="box-heading">
					<a href="{{route('post.show', [$post->id, $post->slug])}}">{{ $post->title }}</a>

					@can('edit-post', $post)
						<a href="{{ route('post.edit',$post->id) }}" class="btn btn-xs edit-link">edit</a>
						<a href="{{ route('post.delete',$post->id) }}" class="btn btn-xs edit-link">&times;</a>
					@endcan

					<time datetime="{{ $post->datetime }}">
						<small>{{ $post->created_at }}</small>
					</time>
				</h1>
			</header>

			<div class="post-content">
				{!! $post->rich_text !!}

				<p class="written-by small">
					<small>- written by
						<a href="{{ url('user/'.$post->user->name) }}">{{ $post->user->email }}</a>
					</small>
				</p>
			</div>

			<footer class="post-footer">
				@include('partials.files')
				@include('partials.tags')


			</footer>
		</article>
	</section>

@endsection
