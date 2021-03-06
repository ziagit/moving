<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobChanged extends Mailable
{
    use Queueable, SerializesModels;
public $job;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->job = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@tingsapp.com')
        ->subject('Job Updated')
        ->with(['job'=>$this->job])
        ->view('mails.jobchanged');
    }
}
