<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kharcha extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table  = 'kharcha';
    protected $guarded = [];



}
