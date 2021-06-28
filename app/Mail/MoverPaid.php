<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MoverPaid extends Mailable
{
    use Queueable, SerializesModels;
    public $earning;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->earning = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@tingsapp.com')
        ->subject('Payment Proceed')
        ->with(['amount'=>$this->earning['carrier_earning']])
        ->view('mails.moverpayment');
    }
}
