<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationType extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table = 'registration_types';
    protected $guarded=[];
}
