@extends('layouts.auth')

@section('content')
    @if($response['success'])
        <div class="alert alert-success">
            {{ $response['messege'] }}
        </div>
    @else
        <div class="alert alert-warning">
            {{ $response['messege'] }}
            <a href="{{ route('login') }}">Fazer login</a>
        </div>
    @endif
@endsection