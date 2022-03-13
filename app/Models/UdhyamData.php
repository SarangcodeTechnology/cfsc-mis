<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UdhyamData extends Model
{
    use HasFactory;
    protected $connection = 'cfsc_mis_data';
    protected $table = 'udhyam_data';
    protected $guarded=[];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function localLevel()
    {
        return $this->belongsTo(LocalLevel::class, 'local_level_id');
    }

    public function kaaryalaya()
    {
        return $this->belongsTo(Kaaryalaya::class, 'kaaryalaya_id');
    }

    public function udhyamType()
    {
        return $this->belongsTo(UdhyamType::class, 'udhyam_type_id');
    }
    public function registrationType()
    {
        return $this->belongsTo(RegistrationType::class, 'registration_type_id');
    }

    public function udhyamFyData()
    {
        return $this->hasMany(UdhyamFyData::class, 'udhyam_id');
    }
}
