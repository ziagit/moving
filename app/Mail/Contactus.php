<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contactus extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $email;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $message)
    {
        $this->message = $message;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@tingsapp.com')
        ->subject('Customer Request')
        ->with(['message'=>$this->message])
        ->with(['name'=>$this->name])
        ->with(['email'=>$this->email])
        ->view('mails.contactus');
    }
}
