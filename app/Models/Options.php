<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'option1',
        'option2',
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class,'order_id');
    }
}
