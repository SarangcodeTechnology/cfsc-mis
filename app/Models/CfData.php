<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CfData extends Model
{
    protected $connection = 'cfsc_mis_data';
    protected $table = 'cf_data';

    protected $guarded = ['first_fug_approval_date'];

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

    public function physiography(){
        return $this->belongsTo(Physiography::class,'physiography_id');
    }

    public function subdivision(){
        return $this->belongsTo(SubDivision::class,'subdivision_id');
    }

    public function vegetationType(){
        return $this->belongsTo(VegetationType::class,'vegetation_type_id');
    }

    public function forestType(){
        return $this->belongsTo(ForestType::class,'forest_type_id');
    }

    public function forestCondition(){
        return $this->belongsTo(ForestCondition::class,'forest_condition_id');
    }

    public function fug_approval_dates(){
        return $this->hasMany(FugApprovalDate::class, 'fug_id');
    }
    public function fug_audit_reports(){
        return $this->hasMany(FugAuditReport::class,'fug_id');
    }
    public function fug_maps(){
        return $this->hasMany(FugMap::class,'fug_id');
    }
}
