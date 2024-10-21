<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function document(){
        return $this->hasMany(Document::class);
    }
}
