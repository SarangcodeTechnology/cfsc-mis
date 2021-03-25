<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $connection = 'cfsc_mis_data';
    public $timestamps = false;

    public function districts(){
        return $this->hasMany(District::class,'province_id');
    }

    public function localLevels(){
        return $this->hasManyThrough(LocalLevel::class, District::class);
    }
}
