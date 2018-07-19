@extends('master')
@section('title', $title)


@section('content')

	<section class="box">
		{!! Form::open(['route' => 'post.store', 'method' => 'post','files'=>true, 'class' => 'post','id'=>'add-form']) !!}

		@include('partials.form')

		{!! Form::close() !!}
	</section>

@endsection
