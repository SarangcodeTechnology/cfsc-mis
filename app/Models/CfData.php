<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CfData extends Model
{
    protected $connection = 'cfsc_mis_data';
    protected $table = 'cf_data';

    protected $casts = [
        "province_id" => "integer",
        "district_id" => "integer",
        "local_level_id" => "integer",
        "area_ha" => "float",
        "hh" => "integer",
        "no_of_person_in_committee" => "integer",
        "women_in_committee" => "integer",
        "men_in_committee" => "integer",
        "scientific_forest_area_ha" => "float"
    ];

    protected $guarded = ['first_fug_approval_date'];

    public function cfugType(){
        return $this->belongsTo(CfugType::class,'cfug_type_id');
    }
    public function division(){
        return $this->belongsTo(Division::class,'division_id');
    }

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

    public function physiography()
    {
        return $this->belongsTo(Physiography::class, 'physiography_id');
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class, 'subdivision_id');
    }

    public function vegetationType()
    {
        return $this->belongsTo(VegetationType::class, 'vegetation_type_id');
    }

    public function forestType()
    {
        return $this->belongsTo(ForestType::class, 'forest_type_id');
    }

    public function forestCondition()
    {
        return $this->belongsTo(ForestCondition::class, 'forest_condition_id');
    }

    public function fug_approval_dates()
    {
        return $this->hasMany(FugApprovalDate::class, 'fug_id');
    }

    public function fug_audit_reports()
    {
        return $this->hasMany(FugAuditReport::class, 'fug_id');
    }

    public function fug_maps()
    {
        return $this->hasMany(FugMap::class, 'fug_id');
    }

    public function kharcha()
    {
        return $this->hasMany(Kharcha::class, 'fug_id');
    }

    public function income()
    {
        return $this->hasMany(Income::class, 'fug_id');
    }

    public function kaaryalaya()
    {
        return $this->belongsTo(Kaaryalaya::class, 'kaaryalaya_id');
    }
    public function cfFyData()
    {
        return $this->hasMany(CfFyData::class, 'fug_id');
    }
}
