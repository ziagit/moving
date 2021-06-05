<?php

namespace App\Http\Controllers\Order;

use App\Carrier;
use App\Constant;
use App\Http\Controllers\Controller;
use App\Item;
use App\Movingsize;
use App\Officesize;
use App\Supply;
use App\Vehicle;
use Exception;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function calculator(Request $request)
    {
        $availableCarriers = array();
        $i = 0;
        $baseFare = $this->baseFare($request); //get the truck fair

        $distance = Constant::where('code', 'distance')->first()->value; //get distance charge
        $taxCharge = Constant::where('code', 'tax')->first()->value; //get tax 
        $serviceFee = Constant::where('code', 'servicecharge')->first()->value; //get service charge
        $distanceCharge = $request->distance * $distance; //distance/km google gave us, 

        $hoursToMove = $this->hoursToMove($request); //get the time that 2 mover + truck 
        $stairTime = $this->stairTime($request); // get the time if stair used
        $suppliesCost = $this->suppliesCost($request); //get supplies cost
        $carriers = Carrier::with('calendars')->get();

        foreach ($carriers as $carrier) {
            //match carrier's available calendar that requested
            $matchedCalendar = $this->checkCalendar($carrier->calendars, $request->moving_date);
            if ($matchedCalendar) {
                //find travel cost
                $travelCost = ($baseFare + $distanceCharge + ($carrier->hourly_rate / 60) * $request->duration); // by 60, is because duration is in minut not hour
                //add 10% service fee
                $travelCost = $travelCost + $travelCost * $serviceFee / 100;
                //return $request->number_of_movers['number'];
                if ($request->moving_type['code'] == 'few_items' || $request->moving_type['code'] == 'junk_removal') {
                    //few items case
                    $movingCost = ($hoursToMove + $stairTime) * $carrier->hourly_rate;
                    $movingCost = $movingCost + $this->disposalFee($request);
                    //add 10% service fee
                    $movingCost = $movingCost + $movingCost * $serviceFee / 100;
                } else {
                    if ($request->number_of_movers['code'] == '1mover') {
                        // 1 mover case
                        $movingCost = ($hoursToMove + 1 + $stairTime) * (($carrier->hourly_rate * 67) / 100);
                        //add 10% service fee
                        $movingCost = $movingCost + $movingCost * $serviceFee / 100;
                    } else if ($request->number_of_movers['code'] == '3movers') {
                        // 3 movers case
                        $movingCost = ($hoursToMove - 1 + $stairTime) * (($carrier->hourly_rate * 133) / 100);
                        //add 10% service fee
                        $movingCost = $movingCost + $movingCost * $serviceFee / 100;
                    } else {
                        // standard case
                        $movingCost = ($hoursToMove + $stairTime) * $carrier->hourly_rate;
                        //add 10% service fee
                        $movingCost = $movingCost + $movingCost * $serviceFee / 100;
                    }
                }
                //add 5% tax 
                $tax = ($travelCost + $movingCost + $suppliesCost) * $taxCharge / 100;
                $total = $travelCost + $movingCost + $suppliesCost + $tax;
                $availableCarriers[$i]['id'] = $carrier->id;
                $availableCarriers[$i]['name'] = $carrier->name;
                $availableCarriers[$i]['company'] = $carrier->company;
                $availableCarriers[$i]['emplyees'] = $carrier->emplyees;
                $availableCarriers[$i]['vehicles'] = $carrier->vehicles;
                $availableCarriers[$i]['year_established'] = $carrier->year_established;
                $availableCarriers[$i]['logo'] = $carrier->logo;
                $availableCarriers[$i]['website'] = $carrier->website;
                $availableCarriers[$i]['detail'] = $carrier->detail;
                $availableCarriers[$i]['rate'] = $carrier->hourly_rate;
                $availableCarriers[$i]['price'] = round($total, 2);
                $availableCarriers[$i]['moving'] = round($movingCost, 2);
                $availableCarriers[$i]['supplies_cost'] = round($suppliesCost, 2);
                $availableCarriers[$i]['travel'] = round($travelCost, 2);
                $availableCarriers[$i]['service_fee'] = $this->serviceFee($movingCost, $travelCost, $serviceFee);
                $availableCarriers[$i]['disposal_fee'] = $this->disposalFee($request);
                $availableCarriers[$i]['tax'] = round($tax, 2);
                $availableCarriers[$i]['votes'] = $carrier->votes;
                $i++;
            }
        }
        //return response()->json($availableCarriers);

        $lowest = $this->getMin($availableCarriers);
        return response()->json($lowest);
    }

    public function getMin($data)
    {
        $minPrice = $data[0]['price'];
        $minCarrier = $data[0];
        for ($i = 0; $i < count($data); $i++) {
            //Find minimum number by min function.
            if ($data[$i]['price'] < $minPrice) {
                // $minPrice = $data[$i]['price'];
                $minCarrier = $data[$i];
            }
        }
        return $minCarrier;
    }
    public function baseFare($request)
    {
        $vehicles = Vehicle::all();
        if ($request->vehicle) {
            $requestedVehicle = $request->vehicle['code'];
            foreach ($vehicles as $vehicle) {
                if ($requestedVehicle == $vehicle->code) {
                    return $vehicle->base_fare;
                }
            }
            return 0;
        }
        return $vehicles->where('code', 'minivan')->first()->base_fare;
    }
    public function hoursToMove($request)
    {
        if ($request->moving_type['code'] == 'office') {
            $sizes = Officesize::get(['code', 'hours_to_move']);
            foreach ($sizes as $size) {
                if ($size->code == $request->moving_size['code']) {
                    return $size->hours_to_move;
                }
            }
        } else if ($request->moving_type['code'] == 'apartment') {
            $sizes = Movingsize::get(['code', 'hours_to_move']);
            foreach ($sizes as $size) {
                if ($size->code == $request->moving_size['code']) {
                    return $size->hours_to_move;
                }
            }
        } else {
            $times = 0;
            foreach ($request->items as $itm) {
                $item = Item::where('code', $itm['code'])->first();
                $times = $times + $itm['number'] * $item->moving_cost;
            }
            return $times / 60;
        }
    }
    public function stairTime($request)
    {
        $floorTime = Constant::where('code', 'floortime')->first()->value; //get time that each floor takes

        $floor = 0;
        if ($request->floors) {
            if ($request->floors['pickup']) {
                $floor = $floor + ($request->floors['pickup'] - 1);
            }
            if ($request->floors['destination']) {
                $floor = $floor + ($request->floors['destination'] - 1);
            }
        }
        return ($floor * $floorTime) / 60;
    }
    public function disposalFee($request)
    {
        $fees = 0;
        if ($request->moving_type['code'] == "junk_removal") {
            foreach ($request->items as $item) {
                $fee = Item::where('code', $item['code'])->first()->disposal_fee;
                $fee = $fee * $item['number'];
                $fees = $fees + $fee;
            }
            return $fees;
        }
        return 0;
    }
    public function serviceFee($movingCost, $travelCost, $serviceCharge)
    {
        $fee = ($movingCost + $travelCost) * $serviceCharge / 100;
        return round($fee, 2);
    }
    public function suppliesCost($request)
    {
        $total = 0;
        if ($request->supplies) {
            foreach ($request->supplies as $supply) {
                $sp = Supply::where('code', $supply['code'])->first();
                $total = $total + ($sp->price * $supply['number']);
            }
        }
        return $total;
    }

    public function checkCalendar($calendars, $date)
    {
        //return $date['date']['date'];
        //return $calendars[0]['day'];
        try {
            foreach ($calendars as $calendar) {
                if ($calendar->day == $date['date']['date'] && $calendar->month == $date['date']['month'] && $calendar->year == $date['date']['year']) {
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
