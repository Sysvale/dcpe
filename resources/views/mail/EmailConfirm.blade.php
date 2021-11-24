@component('mail::message')
<h1>Quase pronto {{ $user->name }}!</h1>

<p>
    Para completar seu cadastro, nós precisamos que você verifique seu endereço de e-mail:
    <a href="">{{ $user->email }}</a>
</p>


@component('mail::button', ['url' => 'http://localhost:8000/register/confirmation/'.$user->id])
    Verificar E-mail
@endcomponent

<p>
    <strong>Botão não funciona?</strong> Então clique no link: 
    <a href="#">https://tal.com</a>
</p>

@component('mail::footer')
        Você recebeu este email porque criou uma nova conta na {{ config('app.name') }}. Se não foi você, por favor ignore este email.
@endcomponent

@endcomponent

