<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CfugType extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table = 'cfug_types';

    public function cfData(){
        return $this->hasMany(CfData::class,'cfug_type_id');
    }

}
