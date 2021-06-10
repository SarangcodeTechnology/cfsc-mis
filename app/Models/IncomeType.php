<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeType extends Model
{
    use HasFactory;

    protected $connection = 'cfsc_mis_data';
    protected $table = 'income_type';

    public function income(){
        return $this->hasOne(Income::class,'income_type_id');
    }

    public function incomeCategory(){
        return $this->belongsTo(IncomeCategory::class,'income_category_id');
    }
}
