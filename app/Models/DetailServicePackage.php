<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailServicePackage extends Model
{
    protected $guarded = ['id'];

    use HasFactory;

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }
}
