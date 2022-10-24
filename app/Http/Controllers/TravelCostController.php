<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TravelCostController extends Controller
{
    public function cost()
    {
        return view('travelCost');
    }

    public function calculate(Request $request)
    {

        $distanca = $request->distance;
        //Skenari A
        //Cmimi per kilometer eshte 5 Euro. Nese udhetimi kalon mbi 100 kilometra cmimi per kilometrat e tjera do te jete 3 Euro per kilometer.
        //Cmimi per ore eshte 4 Euro per nje ore udhetimi.

        if ($distanca > 100) {
            $pricekm = ($distanca - 100) * 3 + (100 * 5);
        } else {
            $pricekm = $distanca * 5;
        }
        $startedAt = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time);
        $endedAt = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time);
        $diff = $endedAt->diffInHours($startedAt);
        $timepriceA = $diff * 4;

        $totalprice = $pricekm + $timepriceA;


//      dd(self::calculateB($startedAt,$endedAt,$distanca));
        dd($totalprice, self::calculateC($startedAt, $endedAt, $distanca));




        return view('travelCost');


    }

    public function calculateB($d1, $d2, $distanca)
    {
        //Skenari B
        //Cmimi per kilometer eshte 3 Euro.
        // Nga ora 00:00 deri ne oren 06:00 cmimi eshte 12 Euro, jashte kesaj fashe orare cmimi per ore eshte 7 Euro.
        //Nese cmimi kalon mbi 70 Euro atehere per qe nga momenti i nisjes se udhetimit per 24 oret e ardheshme udhetimi do te jete i mbuluar nga ky cmim.

        $totalhours = 0;
        $hoursoutSlot = 0;
        $hoursInSlot = 0;
        $priceKm = $distanca * 3;
        for ($d = $d1; $d < $d2; $d->addHour()) {
            $totalhours++;
            $s = explode(" ", $d);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '00:00:00');
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '06:00:00');
            $priceforDay = ["day" => $s[0]];
            if ($d >= $from && $d < $to) {
                $hoursInSlot++;
            } else {
                $hoursoutSlot++;
            }
        }
        $totalhours++;
        $priceInSlot = $hoursInSlot * 12;
        $priceOutSlot = $hoursoutSlot * 7;
        $priceByTime = $priceInSlot + $priceOutSlot;
        if ($priceByTime > 70 && $totalhours >= 24) {
            $priceByTime = $priceByTime - (6 * 12 + 18 * 7) + 70;

        } else if ($priceByTime > 70 && $totalhours < 24) {
            $priceByTime = 70;

        } else {
            $priceByTime = $hoursInSlot * 12 + $hoursoutSlot * 7;
        }

        return $priceKm + $priceByTime;
    }


    function calculateC($d1, $d2, $distanca)
    {
        //Skenari C
        // Cmimi per kilometer eshte 7 Euro. Nese udhetimi kalon mbi 50 kilometra cmimi per kilometrat e tjera eshte 5 Euro. Nese udhetimi kalon 100 kilometra, cmimi per kilometrat e tjera eshte 3 Euro.
        //Nga ora 00:00 deri ne oren 07:00 cmimi per kilometer eshte 10 Euro. Nga ora 07:00 deri ne oren 09:00 dhe nga ora 16:00 deri ne oren 18:30 cmimi eshte 8 Euro. Kurse per fashat e tjera te orarit cmimi eshte 5 Euro.
        $priceKm = 1;
        if ($distanca < 50) {
            $priceKm = $distanca * 7;
        }
        if ($distanca > 50) {
            $priceKm = ($distanca - 50) * 5 + (50 * 7);
        }
        if ($distanca > 100) {
            $priceKm = ($distanca - 100) * 3 + (50 * 5) + (50 * 7);
        }
        $totalhours = 0;
        $hoursoutSlot = 0;
        $hoursInSlot1 = 0;
        $hoursInSlot2 = 0;
        $hoursInSlot3 = 0;
        $hoursInSlotC = 0;
        for ($c = $d1; $c < $d2; $c->addHour()) {
            $totalhours++;
            $s = explode(" ", $c);
            $t1 = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '00:00:00');
            $t2 = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '07:00:00');
            $t3 = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '09:00:00');
            $t4 = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '16:00:00');
            $t5 = Carbon::createFromFormat('Y-m-d H:i:s', $s[0] . ' ' . '18:30:00');
            if ($c >= $t1 && $c < $t2) {
                $hoursInSlot1++;
            } elseif ($c >= $t2 && $c < $t3) {
                $hoursInSlot2++;
            } elseif ($c >= $t4 && $c < $t5) {
                $hoursInSlot3++;
            } else {
                $hoursoutSlot++;
            }
        }
        $timePrice = $hoursInSlot1 * 10 + $hoursInSlot2 * 8 + $hoursInSlot3 * 8 + $hoursoutSlot * 5;;
        return $timePrice + $priceKm;
    }


}
