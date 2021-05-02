<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FugAuditReport extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'cfsc_mis_data';

    public function fug(){
        return $this->belongsTo(CfData::class,'fug_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
