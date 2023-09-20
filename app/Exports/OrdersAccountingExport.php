<?php

namespace App\Exports;

use App\Models\Options;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Morilog\Jalali\Jalalian;

class OrdersAccountingExport implements FromCollection
{
    public $month,$year;
    function __construct($year,$month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //$year = Jalalian::now()->format('Y');
        //$month = Jalalian::now()->format('m');

        $startDate=$this->year."-".$this->month."-01";
        $endDate=Jalalian::fromFormat('Y-m-d',$startDate)->addMonths(1)->subDays(1)->format('Y-m-d');
        //$endDate=Carbon::parse(Carbon::now())->endOfMonth();
        if(Auth::user()->role==2){
            $users=User::where('company',Auth::user()->company)->get();
        }else{
            $users=User::get();
        }

        $counter=0;
        //$options=Options::whereDate('date',">=",$startDate)->whereDate('date',"<=",$endDate)->get();
        //$data=[];


        foreach ($users as $user){
            $sum=0;
            $targetOrders=$user->orders;
            //print_r($targetOrders);
            foreach ($targetOrders as $targetOrder){
                $explodedDate=explode("-",$targetOrder->targetOption->date);
                $convertedDate=\Morilog\Jalali\CalendarUtils::toJalali($explodedDate[0],$explodedDate[1],$explodedDate[2]);
                if ($convertedDate[1]<10){
                    $convertedDate[1]="0".$convertedDate[1];
                }
                if ($convertedDate[2]<10){
                    $convertedDate[2]="0".$convertedDate[2];
                }
                $targetOptionDate=$convertedDate[0].$convertedDate[1].$convertedDate[2];

                $startDate=str_replace("-" , "" ,$startDate);
                $endDate=str_replace("-" , "" ,$endDate);


                if ((int) $targetOptionDate >= (int) $startDate && (int) $targetOptionDate <= $endDate){
                    //echo "salam";
                    $sum++;
                }
            }

            if ($user->type==0){
                $users[$counter]->type="قراردادی";
            }elseif ($user->type==1){
                $users[$counter]->type="پروژه ای";
            }else{
                $users[$counter]->type="سرباز";
            }
            $users[$counter]->counter=$sum;
            $users[$counter]->id=$counter+1;


            unset($users[$counter]->updated_at);
            unset($users[$counter]->remember_token);
            unset($users[$counter]->default_location);
            unset($users[$counter]->role);
            unset($users[$counter]->company);
            unset($users[$counter]->phone);
            unset($users[$counter]->created_at);
            $counter++;
        }

        return $users;
    }
}
