<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FugApprovalDate extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';

    public function fug(){
        return $this->belongsTo(CfData::class,'fug_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
