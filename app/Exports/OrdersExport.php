<?php

namespace App\Exports;

use App\Models\Options;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    public $date;
    public $location;
    function __construct($date,$location)
    {
        $this->date=$date;
        $this->location=$location;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $option=Options::whereDate('date',"=",$this->date)->get();
        if (Auth::user()->role==2){
            $orders=Orders::where('location_id',Auth::user()->default_location+1)->where('order_id',$option[0]->id)->orderBy('location_id','asc')->get();
        }else{
            if (isset($option[0])) {
                if ($this->location=="-1"){
                    $orders = Orders::where('order_id', $option[0]->id)->orderBy('location_id', 'asc')->get();
                }else{
                    $orders = Orders::where('order_id', $option[0]->id)->where('location_id',$this->location+1)->orderBy('id', 'desc')->get();
                }
            }else{
                $orders=Orders::where('order_id',0)->get();
            }
        }


        $counter=0;
        foreach ($orders as $order)
        {
            /*$data[$counter]['تاریخ']=$order->option->date;
            $data['کاربر']=$order->user->name;
            $data['انتخاب']=$order->option;
            $data['نوع کاربر']=$order->user->date;
            $data['محل تحویل']=$order->location->name;*/

            $orders[$counter]->id=$counter+1;


            $orders[$counter]->location_id=$order->location->name;

            $orders[$counter]->date=GregorianToJalalian($order->targetOption->date);

            if ($order->user->type==0){
                $orders[$counter]->order_id="قراردادی";
            }elseif ($order->user->type==1){
                $orders[$counter]->order_id="پروژه ای";
            }else{
                $orders[$counter]->order_id="سرباز";
            }
            //unset($orders[$counter]->order_id);
            $orders[$counter]->user_id=$order->user->name;
            //$orders[$counter]->order_id=null;

            unset($orders[$counter]->company_id);
            unset($orders[$counter]->updated_at);
            unset($orders[$counter]->created_at);



            //$orders[$counter]->user_type=$order->user->type;
            $counter++;
        }
        //print_r($orders);
        //dd();
        return $orders;
    }
}
