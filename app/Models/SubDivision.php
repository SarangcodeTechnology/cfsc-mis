<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivision extends Model
{
    protected $table = 'subdivisions';
    protected $connection = 'cfsc_mis_data';
    public $timestamps = false;
}
