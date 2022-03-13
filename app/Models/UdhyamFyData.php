<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UdhyamFyData extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table = 'udhyam_fy_data';
    protected $guarded=[];

    public function aarthikBarsa()
    {
        return $this->belongsTo(AarthikBarsa::class, 'aarthik_barsa_id');
    }
}
