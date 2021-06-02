<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newPropertyAddedToYourList extends Mailable
{
    use Queueable, SerializesModels;

    private string $email;
    private string $user_name;
    private string $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $user_name, $title)
    {
        $this->email = $email;
        $this->user_name = $user_name;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Novo imóvel salvo em sua lista');
        $this->to($this->email, $this->user_name);
        return $this->view('mail/newPropertyAdded', ['name' => $this->user_name, 'property' => $this->title]);
    }
}
