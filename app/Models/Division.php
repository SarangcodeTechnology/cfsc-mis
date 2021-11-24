<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $guarded = ['id','created_at','updated_at'];
    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }
    public function localLevel(){
        return $this->belongsTo(LocalLevel::class, 'local_level_id');
    }
    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }


}
