@extends('master')
@section('title', $title)


@section('content')

	<section class="box">
		{!! Form::open(['route' => 'post.store', 'method' => 'post', 'class' => 'post','id'=>'add-form']) !!}

		@include('partials.form')

		{!! Form::close() !!}
	</section>

@endsection
