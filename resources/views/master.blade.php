<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('title')</title>

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
</head>
<body class="{{ Request::segment(1) ?: 'home' }}">

	<header class="container">
		@include('flash::message')

		@include('partials.errors')

		@include('partials.navigation')
	</header>


	<main>
		<div class="container">
			@yield('content')
		</div>
	</main>

	<footer class="site-footer container small">
		@foreach (\Config::get('language') as $lang=>$language)
			<a href="{{ url('lang',$lang) }}" class="text-muted">
				@if ($lang == \App::getLocale())
					<strong>{{ $language }}</strong>
				@else {{ $language }}
				@endif
			</a>
		@endforeach
	</footer>


    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
