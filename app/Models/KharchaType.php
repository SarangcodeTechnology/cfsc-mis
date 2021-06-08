<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KharchaType extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table  = 'kharcha_type';

    public function kharcha(){
        return $this->hasOne(Kharcha::class,'kharcha_type_id');
    }

    public function kharchaCategory(){
        return $this->belongsTo(KharchaCategory::class,'kharcha_category_id');
    }
}
