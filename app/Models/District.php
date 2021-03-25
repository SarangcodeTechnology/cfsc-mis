<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $connection = 'cfsc_mis_data';
    public $timestamps = false;
    public function localLevels(){
        return $this->hasMany(LocalLevel::class,'district_id');
    }
}
