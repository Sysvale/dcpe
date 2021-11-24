@extends('layouts.auth')

@section('page', 'Registrar-se')

@section('content')
    {{-- <div style="text-align: center;">
        <img id="identidade" class="mb-4" src="{{ asset('storage/images/versao-a.png') }}" alt="" width="180" >
    </div> --}}

    @if ($errors->any())
        <div class="alert alert-warning">{{ $errors->first() }}</div>
    @endif

    <div class="form-label-group">
        <input name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
        <label for="email">E-mail</label>
    </div>

    <div class="form-label-group">
        <input name="name" class="form-control" placeholder="Nome" value="{{ old('name') }}">
        <label for="name">Nome</label>
    </div>

    <div class="form-label-group">
        <input type="password" name="password" class="form-control" placeholder="Senha">
        <label for="password">Senha</label>
    </div>

    <div class="form-label-group">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar senha">
        <label for="password_confirmation">Confirmar senha</label>
    </div>

    <p><button class="btn btn-lg btn-success btn-block" type="submit" name="cadastro">Cadastrar</button></p>
    <p><a class="btn btn-lg btn-light btn-block" href="{{ route('login') }}">Cancelar</a></p>
@endsection