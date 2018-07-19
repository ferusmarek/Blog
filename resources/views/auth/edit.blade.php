@extends('master')
@section('title', $title)


@section('content')

	<section class="box">
	{!! Form::model($user, ['route' => [ 'user.update', $user->id ], 'method' => 'put', 'files' => true, 'class' => 'post', 'id' => 'edit-form']) !!}

		<header class="post-header">
			<h1 class="box-heading">{{ $title }}</h1>
		</header>

		<div class="row">
			<div class="col-md-3">
				@if($user->avatar)
					<img src="{{ $user->avatar['crop'] }}" alt="{{ $user->name }}" class="avatar">
				@endif
				{!! Form::file('avatar', ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-9">
				{!! Form::email('email', null, [
					'class' => 'form-control form-group',
					'placeholder' => 'email@address.com',
					'required' => true,
					'autofocus' => true,
					'disabled' => true,
				]) !!}

				{!! Form::text('name', null, [
					'class' => 'form-control',
					'placeholder' => 'name',
					'required' => true,
					'autofocus' => true,
				]) !!}

				{!! Form::password('password', [
					'class' => 'form-control',
					'placeholder' => 'password',
				]) !!}

				{!! Form::password('password_confirmation', [
					'class' => 'form-control',
					'placeholder' => 'password, again',
				]) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::button($title, ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<span class="or">
				or {!! link_to('/', 'cancel') !!}
			</span>
		</div>

	{!! Form::close() !!}
	</section>

@endsection
