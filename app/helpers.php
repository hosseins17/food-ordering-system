<?php


function JalaliToGregorian($date)
{
    $date=str_replace("/","-",$date);
    $newDate=explode("-",$date);
    if($newDate[0]<=2000){
        $convertedDate=\Morilog\Jalali\CalendarUtils::toGregorian($newDate[0], $newDate[1], $newDate[2]);
    }else{
        $convertedDate=$newDate;
    }
    return $convertedDate[0]."-".$convertedDate[1]."-".$convertedDate[2];
}

function GregorianToJalalian($date)
{
    $newDate=explode("-",$date);
    $convertedDate=\Morilog\Jalali\CalendarUtils::toJalali($newDate[0], $newDate[1], $newDate[2]);
    return $convertedDate[0]."-".$convertedDate[1]."-".$convertedDate[2];
}

function isValidTimeToSubmitOrDeleteOrder($option){
    $res=false;
    $requestedDate=Morilog\Jalali\Jalalian::fromDateTime($option->date)->toCarbon();
    $diffDays=$requestedDate->diffInDays(\Carbon\Carbon::today()->addDays(1));
    $diffDays2=$requestedDate->diffInDays(\Carbon\Carbon::today()->addDays(3));
    $diffDays3=$requestedDate->diffInDays(\Carbon\Carbon::today()->addDays(2));
    $targetDate=\Carbon\Carbon::createFromFormat('H:i', "08:30")->format("H:i");

    if($requestedDate->diffInHours(\Carbon\Carbon::today()->format("Y-m-d")) >= 24 && $requestedDate >= \Carbon\Carbon::today()->format("Y-m-d")){
            if(\Carbon\Carbon::now()->format("H:i") <= $targetDate || $diffDays > 0){
                $res=true;
                if (\Carbon\Carbon::now()->isWednesday()){
                     //print_r($diffDays2);
                    if($diffDays2==0 && \Carbon\Carbon::now()->format("H:i") >= $targetDate){
                        $res=false;
                    }
                }
                if (\Carbon\Carbon::now()->isThursday()){
                    if($diffDays3==0 && \Carbon\Carbon::now()->format("H:i") >= $targetDate){
                        $res=false;
                    }
                }

            }

    }
   // print_r($diffDays2);


    return $res;
}
