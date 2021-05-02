<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalLevel extends Model
{
    protected $connection = 'cfsc_mis_data';
    public $timestamps = false;
    protected $guarded = [];
}
