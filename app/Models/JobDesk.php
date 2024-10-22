<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDesk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jobList(){
        return $this->hasMany(JobList::class);
    }
}
