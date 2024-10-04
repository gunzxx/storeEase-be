<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Vendor extends Authenticatable implements JWTSubject, HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('profile_img')
            ->singleFile();
    }
}
