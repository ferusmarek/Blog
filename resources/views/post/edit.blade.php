@extends('master')
@section('title',$title)


@section('content')

	<section class="box">
		{!! Form::model($post,['route' => ['post.update',$post->id], 'method' => 'put','files'=>true, 'class' => 'post','id'=>'edit-form']) !!}

			@include('partials.form')

		{!! Form::close() !!}
	</section>

@endsection
