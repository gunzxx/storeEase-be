<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detailServicePackage()
    {
        return $this->belongsTo(DetailServicePackage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function statusOrder()
    {
        return $this->belongsTo(StatusOrder::class);
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function jobDesk()
    {
        return $this->hasMany(JobDesk::class);
    }
}
