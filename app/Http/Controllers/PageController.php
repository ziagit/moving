<?php

namespace App\Http\Controllers;

use App\About;
use App\Faq;
use App\Privacy;
use App\Term;
use App\CarrierFaq;
use App\CarrierPage;
use App\ShipperFaq;
use App\ShipperPage;
use Illuminate\Http\Request;
use Mail;

class PageController extends Controller
{
    public function aboutForm(Request $request){
        $from_email = $request->email;
        $to_name = $request->name;
        $to_email = "eadings20@gmail.com";
        $data = array("name"=>"Tingsapp", "body" => $request->message);
        Mail::send("mails.email", $data, function($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
            ->subject("TignsApp Customers");
            $message->from('eadinds20@gmail.com',"TingsApp");
        });

        return response()->json(['message'=>'Thnaks form contacting us!'],200); 
    }
    public function terms(){
        return response()->json(Term::first());
    }
    public function privacy(){
        return response()->json(Privacy::first());
    }
    public function faq(){
        return response()->json(Faq::first());
    }
    public function carrierFaq(){
        return response()->json(carrierFaq::all());
    }
    public function shipperFaq(){
        return response()->json(ShipperFaq::all());
    }
    public function about(){
        return response()->json(About::first());
    }
    public function shipperPage(){
        return response()->json(ShipperPage::first());
    }
    public function carrierPage(){
        return response()->json(CarrierPage::first());
    }
}
