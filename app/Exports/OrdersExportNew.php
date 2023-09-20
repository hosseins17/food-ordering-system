<?php

namespace App\Exports;

use App\Models\Options;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class OrdersExportNew implements FromArray,ShouldAutoSize
{
    public $date;
    public $location;
    function __construct($date,$location)
    {
        $this->date=$date;
        $this->location=$location;
    }


    public function array(): array
    {
        // TODO: Implement array() method.
        $option=Options::whereDate('date',"=",$this->date)->get();


            if (isset($option[0])) {
                if ($this->location=="-1"){
                    $orders = Orders::where('order_id', $option[0]->id)->orderBy('location_id', 'asc')->get();
                }else{
                    $orders = Orders::where('order_id', $option[0]->id)->where('location_id',$this->location+1)->orderBy('id', 'desc')->get();
                }
            }else{
                $orders=Orders::where('order_id',0)->get();
            }

        $counter = 1;
        $counterBuilding = 1;
        $lastLoc = 1;
        $data = [["","طرشت","",""]];
        foreach ($orders as $order)
        {

            if($lastLoc !== $order->location_id){
                $lastLoc = $order->location_id;
                $data[$counter] = ["",$order->location->name,"",""];
                $counterBuilding = 1;
                $counter++;
           // }else{
            }
                $option1 = str_replace(" ","",$order->targetOption->option1);
                $option2 = str_replace(" ","",$order->targetOption->option2);
                $userOption = str_replace(" ","",$order->option);

                if ($option1 == $userOption){
                    $option1="*";
                    $option2="";
                }else if ($option2 == $userOption){
                    $option1="";
                    $option2="*";
                }

                $data[$counter]=[
                    $counterBuilding,
                    $order->user->name,
                    $option1,
                    $option2,
                ];
                $counterBuilding++;
          //  }
            $counter++;
        }

        return $data;
    }
}
