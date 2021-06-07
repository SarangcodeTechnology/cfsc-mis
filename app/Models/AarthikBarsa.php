<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AarthikBarsa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'cfsc_mis_data';
    protected $table = 'aarthik_barsa';


}
