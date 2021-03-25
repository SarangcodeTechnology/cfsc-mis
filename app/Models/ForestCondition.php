<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForestCondition extends Model
{
    protected $connection = 'cfsc_mis_data';
    public $timestamps = false;
}
