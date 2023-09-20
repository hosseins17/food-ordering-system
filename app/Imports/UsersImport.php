<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $pass= substr($row[3], 1);
        return new User([
            'name'     => $row[0]." ".$row[1],
            'phone'    => $row[3],
            'type' => $row[5],
            'company'=>$row[4],
            'default_location' => $row[6],
            'role' => (isset($row[4])) ? $row[4] : 0 ,
            'password' => bcrypt($pass),
        ]);
    }
}
