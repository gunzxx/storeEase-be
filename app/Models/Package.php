<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Package extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    public function packageCategory(){
        return $this->belongsTo(PackageCategory::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function detailServicePackage(){
        return $this->hasMany(DetailServicePackage::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('preview_img');
    }
}
