<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class EmailConfirm extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    // no exemplo é usando o stdClass, mas usualmente
    // devo colocar o User model
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $this->subject('Confirmação do endereço de email');
        $this->to($this->user->email, $this->user->name);
        

        return $this->markdown('mail.EmailConfirm', ['user' => $this->user]);
    }
}
