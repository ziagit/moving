<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SignalWire\Rest\Client;
class NewMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sms)
    {
        $client = new Client(
            '9e795027-6374-4fc4-b41b-5feee6200fe2',
            'PT03a838278449788b7a38b8e7d8c7e4c2fe41a706a351942f',
            array("signalwireSpaceUrl" => "tingsapp.signalwire.com")
        );

        $message = $client->messages
        ->create("+16043586261", // to
                 array("from" => "+18888186061", "body" => "Hello from TingsApp, Dear Naqib if you get this message please reply me on Whatsapp. Zia")
        );
        return $message->sid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
/*     public function broadcastOn()
    {
        return new Channel('home');
    } */
}
