<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('first_meet')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();

        $this
            ->addMediaCollection('down_payment')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
    }
}
