<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
