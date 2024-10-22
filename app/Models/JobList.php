<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jobDesk(){
        return $this->belongsTo(JobDesk::class);
    }
}
