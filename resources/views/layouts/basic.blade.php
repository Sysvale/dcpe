<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{ asset('fav.png') }}"/>
		<title>{{ config('app.name') }}</title>

		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<script href="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
	<body>
		<div id="app">
			<main class="py-4 d-flex h-100 relative align-items-center">
                @yield('content')
            </main>
		</div>

		{{-- Load the application scripts --}}
		<script src="{{ asset('js/app.js') }}"></script>
	</body>
</html>
