<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function packageCategory(){
        return $this->belongsTo(PackageCategory::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }
}
