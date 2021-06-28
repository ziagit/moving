<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Config;
use SignalWire\Rest\Client;
use SignalWire\LaML;

class Sms
{

    public function verify($phone, $code)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "TingsApp: " . $code . " is your verification code.")
            );
        return $message;
    }
    public function newJob($phone, $job)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "TingsApp: Dear partner a new job arrived in your dashboard")
            );
        return $message;
    }
    public function updateJob($phone, $order)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "Dear customer your order is beeing " . $order->status. " By TingsApp")
            );
        return $message;
    }
    public function jobChanged($phone, $order)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "Dear partner your job is beeing " . $order->status. " By TingsApp")
            );
        return $message;
    }
    public function jobCanceled($phone, $order)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "Dear partner your job is beeing " . $order->status. " By TingsApp")
            );
        return $message;
    }
    public function customerPaid($phone, $order)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "Dear customer your payment was successfull to TingsApp due to " . $order . " Order")
            );
        return $message;
    }
    public function moverPaid($phone, $earning)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "Dear partner you are paid by TingsApp due to completion of " . $earning->order_id . " Order")
            );
        return $message;
    }
    public function refunded($phone, $amount)
    {
        $client = Config::get('services.signalwire.client');
        $token = Config::get('services.signalwire.token');
        $space_url = Config::get('services.signalwire.space_url');

        $client = new Client(
            $client,
            $token,
            $space_url
        );
        $message = $client->messages
            ->create(
                "+18888186061", // to
                array("from" => "+18888186061", "body" => "Dear customer your request to refund is completed by TingsApp amount: ".$amount)
            );
        return $message;
    }
}
