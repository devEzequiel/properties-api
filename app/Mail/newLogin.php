<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class newLogin extends Mailable
{
    use Queueable, SerializesModels;

    private int $id;
    private string $email;
    private string $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $email, $name)
    {
        $this->email = $email;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->email);
        $this->subject('Novo Login Feito em Sua Conta');
        $this->to($this->email, $this->name);
        return $this->view('mail/newLogin', ['name' => $this->name, 'id' => $this->id]);
    }
}
