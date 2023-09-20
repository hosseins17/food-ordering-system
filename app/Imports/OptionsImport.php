<?php

namespace App\Imports;

use App\Models\Options;
use Maatwebsite\Excel\Concerns\ToModel;
use Morilog\Jalali\Jalalian;

class OptionsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //date must be in jalali to work true;
        $exportedDate=explode("-",$row[0]);
        if ($exportedDate[0]<2000){
            $newDate=\Morilog\Jalali\CalendarUtils::toGregorian($exportedDate[0], $exportedDate[1], $exportedDate[2]);
            $row[0]=$newDate[0] ."-". $newDate[1] ."-". $newDate[2];
        }


        return new Options([
            'date'     => $row[0],
            'option1'    => $row[1],
            'option2'    => $row[2],
        ]);
    }
}
