<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerPaid extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $amount;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->order = $data['order'];
        $this->amount = $data['cost'];
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
        ->with(['order'=>$this->order])
        ->with(['amount'=>$this->amount])
        ->view('mails.payment');
    }
}
