<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    protected $guarded = ['id'];
    
    use HasFactory;

    public function package(){
        return $this->hasMany(Package::class);
    }
}
