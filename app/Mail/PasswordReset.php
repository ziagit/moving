<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->code = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@tingsapp.com')
            ->subject('Password Reset')
            ->with(['code' => $this->code])
            ->view('mails.resetpassword');
    }
}
