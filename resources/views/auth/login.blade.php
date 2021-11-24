@extends('layouts.auth')

@section('page', 'Login')

@section('content')
	
	{{-- <div style="text-align: center;">
			<img id="identidade" class="mb-4" src="{{ asset('storage/images/versao-a.png') }}" alt="" width="180" >
		</div> --}}
		
	@if($errors->any())
		<div class="alert alert-warning">
			{{ $errors->first() }}
		</div>
	@endif

	<div class="form-label-group">
		<input name="email" class="form-control" placeholder="E-mail" value="{{ old('email') }}" autofocus>
		<label for="email">E-mail</label>
	</div>

	<div class="form-label-group">
		<input type="password" name="password" class="form-control" placeholder="Senha">
		<label for="password">Senha</label>
	</div>
	
	<div style="display: flex; justify-content: space-between">
		<div class="form-check">
			<input name="remember" class="form-check-input" type="checkbox" id="remember">
			<label class="form-check-label" for="remember">
				Lembrar-me
			</label>
		</div>
		<div>
			<p><a href="{{ route('password.request') }}">Esqueci minha senha</a></p>
		</div>
	</div>

	<p><button class="btn btn-lg btn-success btn-block" type="submit" name="button">Entrar</button></p>
	<p>Não tem conta? <a href="{{ route('register') }}">Cadastre-se!</a></p>

@endsection