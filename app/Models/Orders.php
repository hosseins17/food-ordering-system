<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'location_id',
        'company_id',
        'option',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function targetOption()
    {
        return $this->belongsTo(Options::class, 'order_id');
    }
    public function location()
    {
        return $this->belongsTo(Locations::class,'location_id');
    }

}
