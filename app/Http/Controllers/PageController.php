<?php

namespace App\Http\Controllers;

use App\About;
use App\Faq;
use App\Privacy;
use App\Term;
use App\CarrierFaq;
use App\CarrierPage;
use App\Legal;
use App\Mail\Contactus;
use App\ShipperFaq;
use App\ShipperPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function aboutForm(Request $request){
        Mail::to("support@tingsapp.com")->queue(new Contactus($request->name, $request->email, $request->message));
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
    public function legalsPage(){
        return response()->json(Legal::first());
    }
}
