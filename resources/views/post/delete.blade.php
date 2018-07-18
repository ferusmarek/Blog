@extends('master')
@section('title',$title)


@section('content')

	<section class="box">
		{!! Form::model($post,['route' => ['post.destroy',$post->id], 'method' => 'delete', 'class' => 'post','id'=>'delete-form']) !!}

        <header class="post-header">
            <h1 class="box-heading">
                Sure you wanna do this?
            </h1>

        </header>
        {{--Post teaser --}}
        <blockquote class="form-group">
            <h3>&ldquo;{{ $post->title }}&rdquo;</h3>
            <p class="teaser">{{ $post->teaser }}</p>
        </blockquote>
        {{--Delete Post field --}}
        <div class="form-group">
            {!! Form::button('Delete post',['type' => 'submit','class'=>'btn btn-primary'])!!}
        <span class="or">or {!! link_back('cancel')!!}</span>

        </div>
		{!! Form::close() !!}
	</section>

@endsection
