<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KharchaCategory extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table  = 'kharcha_categories';
    public function kharcha_types(){
        return $this->hasMany(KharchaType::class,'kharcha_category_id');
    }
}
