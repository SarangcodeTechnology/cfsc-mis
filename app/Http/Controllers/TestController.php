<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\AarthikBarsa;
use App\Models\CfData;
use App\Models\Kharcha;
use App\Models\Province;
use App\Models\LocalLevel;
use App\Models\District;
use App\Models\KharchaCategory;
use App\Models\Permission;
use App\Models\Role;
use App\Models\TempGandakiModel;
use App\Models\User;
use App\Module\Permission as ModulePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function trial(){
        return 'he;o';
        $permissions = [];
        $additionalPermissions =  collect(User::first()->permissions);
        $roles = User::first()->roles;
        foreach($additionalPermissions as $permission){
            array_push($permissions, $permission->name);
        }
        foreach($roles as $role){
            foreach($role->permissions as $rolePermission){
                array_push($permissions, $rolePermission->name);
            }
        }

        return $permissions;
        return CfData::first();
        $cfData =  CfData::max('area_ha');
        return $cfData;
    }
    public function index(){
        $i = 0;
        foreach(Kharcha::select('fug_id','aarthik_barsa_id')->distinct()->get() as $item){
            $aarthik_barsa_id = $item->aarthik_barsa_id;
            $fug_id = $item->fug_id;
            $data[$i]['aarthik_barsa'] = AarthikBarsa::find($aarthik_barsa_id);
            $data[$i]['fug'] = CfData::find($fug_id);
            $data[$i]['items'] = KharchaCategory::with(['kharcha_types'=>function($query) use ($aarthik_barsa_id,$fug_id){
                 $query->with('kharcha',function($kharchaQuery) use ($aarthik_barsa_id,$fug_id){
                     $kharchaQuery->where('aarthik_barsa_id',$aarthik_barsa_id)->where('fug_id',$fug_id);
                 });
             }])->get();
            $i++;
        }
        return $data;


        return User::first()->permissions;
//    saving final cfData
//        $nepaliDistrict = TempGandakiModel::all();
//        foreach($nepaliDistrict as $item){
//            $tempCfData = new \App\Models\CfData();
//            // province_id
//            $tempCfData->province_id = 4;
//            // district_id
//            $tempCfData->district_id = $item->district_id ? \App\Models\District::where('name',$item->district_id)->first()->id : 0;
//            // ward
//            $tempCfData->ward = $item->ward ?? '';
//            // fug_name
//            $tempCfData->fug_name = $item->fug_name ?? '';
//            // fug_code
//            $tempCfData->fug_code = $item->fug_code ?? '';
//
//            // fug_pan_no
//            $tempCfData->fug_pan_no = $item->fug_pan_no ?? '' ;
//
//            // hh
//            $tempCfData->hh = $item->hh ?? 0;
//
//            // population
//            $tempCfData->population = $item->population ?? 0;
//
//            // women_population
//            $tempCfData->women_population = $item->women_population ?? 0;
//
//            // men_population
//            $tempCfData->men_population = $item->men_population ?? 0;
//
//            // local_level_id
//            $tempCfData->local_level_id = $item->local_level_id ? \App\Models\LocalLevel::where('name',$item->local_level_id)->first()->id : 0;
//
//            // area_ha
//            $tempCfData->area_ha = $item->area_ha ?? 0;
//            // no_of_person_in_committee
//            $tempCfData->no_of_person_in_committee = $item->no_of_person_in_committee ?? 0;
//            // women_in_committee
//            $tempCfData->women_in_committee = $item->women_in_committee ?? 0;
//            // men_in_committee
//            $tempCfData->men_in_committee = $item->men_in_committee ?? 0;
//
//            // scientific_forest_approval_date
//            $tempCfData->scientific_forest_approval_date = $item->scientific_forest_approval_date ?? "";
//
//            // scientific_forest_area_ha
//            $tempCfData->scientific_forest_area_ha = $item->scientific_forest_area_ha ?? 0;
//
//
//            // forest_based_industry_operations
//            $tempCfData->forest_based_industry_operations = $item->forest_based_industry_operations ?? "";
//
//            // forest_based_tourism_operations
//            $tempCfData->forest_based_tourism_operations = $item->forest_based_tourism_operations ?? "";
//
//            // remarks
//            $tempCfData->remarks = $item->remarks ?? '';
//
//             $tempCfData->save();
//
//
//        }




        return 'done';



//        return $fug = CfData::with(['fug_approval_dates','fug_audit_reports','fug_maps'])->find(3909);
//        return $fug->fug_audit_reports;




//        return '--------';


        // getting local_levels of gandaki
        $distinctLocalLevel = TempGandakiModel::select('local_level_id')->distinct()->get();
        $localLevel = [];
        foreach ($distinctLocalLevel as $item){
            $district = TempGandakiModel::where('local_level_id',$item->local_level_id)->first()->district_id;
            $district_id = District::where('name',$district)->first()->id;
            $localLevel[] = [
                "name" => $item->local_level_id,
                "district_id" => $district_id
            ];

        }
        foreach($localLevel as $item){
            LocalLevel::create($item);
        }
        return 'done';


        foreach($nepaliDistrict as $item){
            $cfData = new \App\Models\LocalLevel();
            $cfData->district_id = $item->district_id ? \App\Models\District::where('name',$item->district_id)->first()->id : 0;
            $cfData->name = $item->local_level_id ?? '';
            $cfData->save();
        }
        return 'done';

        // getting gandaki's data
        foreach($nepaliDistrict as $item){
            $tempCfData = new \App\Models\CfData();
            // province_id
            $tempCfData->province_id = 4;
            // district_id
            $tempCfData->district_id = $item->district_id ? \App\Models\District::where('name',$item->district_id)->first()->id : 0;
            // ward
            $tempCfData->ward = $item->ward ?? '';
            // fug_name
            $tempCfData->fug_name = $item->fug_name ?? '';
            // fug_code
            $tempCfData->fug_code = $item->fug_code ?? '';

            // fug_pan_no
            $tempCfData->fug_pan_no = $item->fug_pan_no ?? '' ;

            // hh
            $tempCfData->hh = $item->hh ?? 0;

            // population
            $tempCfData->population = $item->population ?? 0;

            // women_population
            $tempCfData->women_population = $item->women_population ?? 0;

            // men_population
            $tempCfData->men_population = $item->men_population ?? 0;

            // local_level_id
            $tempCfData->local_level_id = $item->local_level_id ? \App\Models\LocalLevel::where('name',$item->local_level_id)->first()->id : 0;

            // area_ha
            $tempCfData->area_ha = $item->area_ha ?? 0;
            // no_of_person_in_committee
            $tempCfData->no_of_person_in_committee = $item->no_of_person_in_committee ?? 0;
            // women_in_committee
            $tempCfData->women_in_committee = $item->women_in_committee ?? 0;
            // men_in_committee
            $tempCfData->men_in_committee = $item->men_in_committee ?? 0;

            // scientific_forest_approval_date
            $tempCfData->scientific_forest_approval_date = $item->scientific_forest_approval_date ?? "";

            // scientific_forest_area_ha
            $tempCfData->scientific_forest_area_ha = $item->scientific_forest_area_ha ?? 0;


            // forest_based_industry_operations
            $tempCfData->forest_based_industry_operations = $item->forest_based_industry_operations ?? "";

            // forest_based_tourism_operations
            $tempCfData->forest_based_tourism_operations = $item->forest_based_tourism_operations ?? "";

            // remarks
            $tempCfData->remarks = $item->remarks ?? '';

            // $tempCfData->save();


        }

    }
}
