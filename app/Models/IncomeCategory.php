<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $connection = 'cfsc_mis_data';

    public function income_types()
    {
        return $this->hasMany(IncomeType::class, 'income_category_id');
    }
}
