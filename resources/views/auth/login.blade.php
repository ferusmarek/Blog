@extends('master')
@section('title', 'Login')



@section('content')

	{!! Form::open([ 'route' => 'login', 'class' => 'box box-auth' ]) !!}

		<h2 class="box-auth-heading">
			{{ trans('auth.login') }}
		</h2>
		

		{!! Form::email('email', null, [
			'class' => 'form-control',
			'placeholder' =>  trans('auth.email'),
			'required' => true,
			'autofocus' => true,
		]) !!}

		{!! Form::password('password', [
			'class' => 'form-control',
			'placeholder' => trans('auth.password'),
			'required' => true,
		]) !!}

		<label class="checkbox">
			{!! Form::checkbox('remember', 'remember', true) !!}
			{{ trans('auth.remember_me') }}

		</label>

		{!! Form::button( trans('auth.login'), [
			'type' => 'submit',
			'class' => 'btn btn-lg btn-primary btn-block'
		]) !!}

		<p class="alt-action text-center">

			{!! trans('auth.alt_login',[
				'link_1' =>'<a href="'. url('login/github').'" class="btn-github">Github</a>',
				'link_2' =>'<a href="'.	url('login/facebook').'" class="btn-facebook">Facebook</a>',
				'link_3' =>'<a href="'.	route('register').'">'. trans('auth.create_account').'</a>',

				]) !!}


		</p>

	{!! Form::close() !!}




@endsection
