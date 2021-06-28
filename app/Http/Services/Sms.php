<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Config;
use SignalWire\Rest\Client;
use SignalWire\LaML;

class Sms
{
    public $client;
    public $from;
    public $bas_url;
    public function __construct()
    {
        $this->client = new Client(
            Config::get('services.signalwire.client'),
            Config::get('services.signalwire.token'),
            Config::get('services.signalwire.space_url')
        );
        $this->from = Config::get('services.signalwire.from');
        $this->bas_url =  "https://tingsapp.com";
    }
    public function verify($phone, $code)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array("from" => $this->from, "body" => "TingsApp: " . $code . " is your verification code.")
            );
        return $message;
    }
    public function newJob($phone, $job)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from,
                    "body" => "TingsApp: Dear partner a new job arrived in your dashboard, ID: " . $job,
                )
            );
        return $message;
    }
    public function updateOrder($phone, $order)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from,
                    "body" => "TingsApp: Dear customer your order is beeing " . $order->status . " By TingsApp, ID: " . $order->uniqid
                )
            );
        return $message;
    }
    public function jobChanged($phone, $job)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from,
                    "body" => "TingsApp: Dear partner your job is beeing updated, ID: " . $job,
                )
            );
        return $message;
    }
    public function jobCanceled($phone, $job)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from,
                    "body" => "TingsApp: Dear partner your job is beeing canceled, ID: " . $job,
                )
            );
        return $message;
    }
    public function customerPaid($phone, $order)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from,
                    "body" => "TingsApp: Dear customer your payment was successfull due to " . $order['uniqid'] . " Order, amount: " . $order['cost']
                )
            );
        return $message;
    }
    public function moverPaid($phone, $amount)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from, 
                    "body" => "TingsApp: Dear partner you are paid by TingsApp due to completion of jobs, amount: ".$amount)
            );
        return $message;
    }
    public function refunded($phone, $amount)
    {
        $message = $this->client->messages
            ->create(
                "+18888186061", // to
                array(
                    "from" => $this->from, 
                    "body" => "TingsApp: Dear customer your refund is completed successfully by TingsApp, amount: " . $amount)
            );
        return $message;
    }
}
