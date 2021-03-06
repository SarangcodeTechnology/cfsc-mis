<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\AarthikBarsa;
use App\Models\CfData;
use App\Models\CfFyData;
use App\Models\CfugType;
use App\Models\Division;
use App\Models\ForestCondition;
use App\Models\ForestType;
use App\Models\FugApprovalDate;
use App\Models\FugAuditReport;
use App\Models\FugMap;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\Kaaryalaya;
use App\Models\Kharcha;
use App\Models\KharchaCategory;
use App\Models\Permission;
use App\Models\Physiography;
use App\Models\Province;
use App\Models\RegistrationType;
use App\Models\Role;
use App\Models\SubDivision;
use App\Models\UdhyamData;
use App\Models\UdhyamFyData;
use App\Models\UdhyamType;
use App\Models\User;
use App\Models\VegetationType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function CFData(Request $request)
    {
        try {
            if ($request->search) {
                $search = $request->search;
                $cfData = CfData::when(!empty($request->filterData->provinces), function ($query) use ($request) {
                    $query->whereIn('province_id', $request->filterData->provinces);
                })->with(['district', 'province', 'localLevel', 'fug_approval_dates', 'fug_audit_reports', 'fug_maps','kaaryalaya','cfFyData'])->get();
                $cfData = CollectionHelper::paginate($cfData->filter(function ($item) use ($search) {
                    return false !== stripos($item, $search);
                })->values(), $request->totalItems);
            } else {
                $filterData = json_decode($request->filterData);
                $cfData = CfData::
                //Province
                when(!empty($filterData->provinces), function ($query) use ($filterData) {
                    $query->whereIn('province_id', $filterData->provinces);
                })
                    //District
                    ->when(!empty($filterData->districts), function ($query) use ($filterData) {
                        $query->whereIn('district_id', $filterData->districts);
                    })
                    //Local Level
                    ->when(!empty($filterData->localLevels), function ($query) use ($filterData) {
                        $query->whereIn('local_level_id', $filterData->localLevels);
                    })
                    //Ward
                    ->when(!empty($filterData->wards), function ($query) use ($filterData) {
                        $query->whereIn('ward', $filterData->wards);
                    })
                    //Area HA
                    ->when($filterData->areaHa->from != 0 || $filterData->areaHa->to != 0, function ($query) use ($filterData) {
                        $query->where('area_ha', '>=', (int)$filterData->areaHa->from)->where('area_ha', '<=', (int)$filterData->areaHa->to);
                    })
//                    //HH
//                    ->when($filterData->hh->from != 0 || $filterData->hh->to != 0, function ($query) use ($filterData) {
//                        $query->where('hh', '>=', (int)$filterData->hh->from)->where('hh', '<=', (int)$filterData->hh->to);
//                    })
//                    //Total Population
//                    ->when($filterData->totalPopulation->from != 0 || $filterData->totalPopulation->to != 0, function ($query) use ($filterData) {
//                        $query->where('population', '>=', (int)$filterData->totalPopulation->from)->where('population', '<=', (int)$filterData->totalPopulation->to);
//                    })
//                    //Men Population
//                    ->when($filterData->menPopulation->from != 0 || $filterData->menPopulation->to != 0, function ($query) use ($filterData) {
//                        $query->where('men_population', '>=', (int)$filterData->menPopulation->from)->where('men_population', '<=', (int)$filterData->menPopulation->to);
//                    })
//                    //Women Population
//                    ->when($filterData->womenPopulation->from != 0 || $filterData->womenPopulation->to != 0, function ($query) use ($filterData) {
//                        $query->where('women_population', '>=', (int)$filterData->womenPopulation->from)->where('women_population', '<=', (int)$filterData->womenPopulation->to);
//                    })
//                    //Total Person in Committee
//                    ->when($filterData->numberOfPersonInCommittee->from != 0 || $filterData->numberOfPersonInCommittee->to != 0, function ($query) use ($filterData) {
//                        $query->where('no_of_person_in_committee', '>=', (int)$filterData->numberOfPersonInCommittee->from)->where('no_of_person_in_committee', '<=', (int)$filterData->numberOfPersonInCommittee->to);
//                    })
//                    //Men in Committee
//                    ->when($filterData->menInCommittee->from != 0 || $filterData->menInCommittee->to != 0, function ($query) use ($filterData) {
//                        $query->where('men_in_committee', '>=', (int)$filterData->menInCommittee->from)->where('men_in_committee', '<=', (int)$filterData->menInCommittee->to);
//                    })
//                    //Women in Committee
//                    ->when($filterData->womenInCommittee->from != 0 || $filterData->womenInCommittee->to != 0, function ($query) use ($filterData) {
//                        $query->where('women_in_committee', '>=', (int)$filterData->womenInCommittee->from)->where('women_in_committee', '<=', (int)$filterData->womenInCommittee->to);
//                    })
                    ->with(['division', 'subDivision', 'cfugType', 'district', 'province', 'localLevel', 'fug_approval_dates', 'fug_audit_reports', 'fug_maps','kaaryalaya','cfFyData'])->orderBy('created_at', 'desc')->paginate($request->totalItems);
            }
//            // for kharcha data in fug
            $kharcha = [];
            foreach ($cfData as $cfDataKey => $cfDataItem) {
                $fug_id = $cfDataItem->id;

                $i = 0;
                $kharcha =[];
                foreach(Kharcha::select('fug_id','aarthik_barsa_id')->distinct()->get() as $item){
                   if($item['fug_id']==$fug_id){
                       $aarthik_barsa_id = $item->aarthik_barsa_id;
                       $fug_id = $item->fug_id;
                       $kharcha[$i]['aarthik_barsa'] = AarthikBarsa::find($aarthik_barsa_id);
                       $kharcha[$i]['fug'] = CfData::find($fug_id);
                       $kharcha[$i]['items'] = KharchaCategory::with(['kharcha_types'=>function($query) use ($aarthik_barsa_id,$fug_id){
                           $query->with('kharcha',function($kharchaQuery) use ($aarthik_barsa_id,$fug_id){
                               $kharchaQuery->where('aarthik_barsa_id',$aarthik_barsa_id)->where('fug_id',$fug_id);
                           });
                       }])->get();
                       $i++;
                   }
                }
//                $filterData = json_decode($request->filterData);
//                $aarthik_barsa_ids = $filterData->aarthikBarsaIds;
//                $fug_ids = $filterData->cfugIds;
//                $kharchaCollection  = collect($kharcha);
//                $kharcha = $kharchaCollection->when(!empty($aarthik_barsa_ids),function($query) use ($aarthik_barsa_ids){
//                    return $query->whereIn('aarthik_barsa.id',$aarthik_barsa_ids);
//                })->when(!empty($fug_ids),function($query) use ($fug_ids){
//                    return $query->whereIn('fug.id',$fug_ids);
//                })->values();

//                foreach (Kharcha::where('fug_id', $fug_id)->select('fug_id', 'aarthik_barsa_id')->distinct()->get() as $i => $item) {
//                    $aarthik_barsa_id = $item->aarthik_barsa_id;
//                    $fug_id = $item->fug_id;
//                    $kharcha[$i]['aarthik_barsa'] = AarthikBarsa::find($aarthik_barsa_id);
//                    $kharcha[$i]['fug'] = CfData::find($fug_id);
//                    $kharcha[$i]['items'] = KharchaCategory::with(['kharcha_types' => function ($query) use ($aarthik_barsa_id, $fug_id) {
//                        $query->with('kharcha', function ($kharchaQuery) use ($aarthik_barsa_id, $fug_id) {
//                            $kharchaQuery->where('aarthik_barsa_id', $aarthik_barsa_id)->where('fug_id', $fug_id);
//                        });
//                    }])->get();
//                }
                $cfData[$cfDataKey]['kharcha'] = $kharcha;
                $kharcha = [];
            }
//
//            // for income data in fug
            $income = [];
            foreach ($cfData as $cfDataKey => $cfDataItem) {
                $fug_id = $cfDataItem->id;
                $i = 0;
                $income = [];
                foreach(Income::select('fug_id','aarthik_barsa_id')->distinct()->get() as $item){
                    if($item['fug_id']==$fug_id) {
                        $aarthik_barsa_id = $item->aarthik_barsa_id;
                        $fug_id = $item->fug_id;
                        $income[$i]['aarthik_barsa'] = AarthikBarsa::find($aarthik_barsa_id);
                        $income[$i]['fug'] = CfData::find($fug_id);
                        $income[$i]['items'] = IncomeCategory::with(['income_types' => function ($query) use ($aarthik_barsa_id, $fug_id) {
                            $query->with('income', function ($incomeQuery) use ($aarthik_barsa_id, $fug_id) {
                                $incomeQuery->where('aarthik_barsa_id', $aarthik_barsa_id)->where('fug_id', $fug_id);
                            });
                        }])->get();
                        $i++;
                    }
                }
//                $filterData = json_decode($request->filterData);
//                $aarthik_barsa_ids = $filterData->aarthikBarsaIds;
//                $fug_ids = $filterData->cfugIds;
//                $incomeCollection  = collect($income);
//                $income = $incomeCollection->when(!empty($aarthik_barsa_ids),function($query) use ($aarthik_barsa_ids){
//                    return $query->whereIn('aarthik_barsa.id',$aarthik_barsa_ids);
//                })->when(!empty($fug_ids),function($query) use ($fug_ids){
//                    return $query->whereIn('fug.id',$fug_ids);
//                })->values();


//                foreach (Income::where('fug_id', $fug_id)->select('fug_id', 'aarthik_barsa_id')->distinct()->get() as $i => $item) {
//                    $aarthik_barsa_id = $item->aarthik_barsa_id;
//                    $fug_id = $item->fug_id;
//                    $income[$i]['aarthik_barsa'] = AarthikBarsa::find($aarthik_barsa_id);
//                    $income[$i]['fug'] = CfData::find($fug_id);
//                    $income[$i]['items'] = IncomeCategory::with(['income_types' => function ($query) use ($aarthik_barsa_id, $fug_id) {
//                        $query->with('income', function ($incomeQuery) use ($aarthik_barsa_id, $fug_id) {
//                            $incomeQuery->where('aarthik_barsa_id', $aarthik_barsa_id)->where('fug_id', $fug_id);
//                        });
//                    }])->get();
//                }
                $cfData[$cfDataKey]['income'] = $income;
                $income = [];
            }

            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data loaded successfully.',
                'data' => [
                    'cfData' => $cfData,
                    'totalCfData' => $cfData['total'],
                ]
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getKharchaHeaders()
    {
        $headers = [
            ['text' => "????????????????????????", 'value' => "actions"],
            ['text' => "?????? ??????????????????????????? ????????????", 'value' => "fug.fug_name"],
            ['text' => "?????????????????? ????????????", 'value' => "aarthik_barsa.name"],
        ];
        $categoryHeader = [];
        foreach (KharchaCategory::all() as $itemKey => $item) {
            $colspan = 0;
            foreach ($item->kharcha_types as $subItemKey => $subItem) {
                $data['text'] = $subItem->title;
                $data['value'] = "items[{$itemKey}].kharcha_types[{$subItemKey}].kharcha.jamma";
                array_push($headers, $data);
                $colspan++;
            }
            $categoryData['title'] = $item->title;
            $categoryData['colspan'] = $colspan;
            if ($colspan) array_push($categoryHeader, $categoryData);
        }

        return response([
            'status' => 200,
            'type' => 'success',
            'message' => 'Kharcha headers loaded successfully.',
            'data' => [
                'headers' => $headers,
                'categoryHeader' => $categoryHeader,
            ]
        ]);
    }

    public function getIncomeHeaders()
    {
        $headers = [
            ['text' => "????????????????????????", 'value' => "actions"],
            ['text' => "?????? ??????????????????????????? ????????????", 'value' => "fug.fug_name"],
            ['text' => "?????????????????? ????????????", 'value' => "aarthik_barsa.name"],
        ];
        $categoryHeader = [];

        foreach (IncomeCategory::all() as $itemKey => $item) {
            $colspan = 0;
            foreach ($item->income_types as $subItemKey => $subItem) {
                $data['text'] = $subItem->title;
                $data['value'] = "items[{$itemKey}].income_types[{$subItemKey}].income.jamma";
                array_push($headers, $data);
                $colspan++;
            }
            $categoryData['title'] = $item->title;
            $categoryData['colspan'] = $colspan;
            if ($colspan) array_push($categoryHeader, $categoryData);
        }


        return response([
            'status' => 200,
            'type' => 'success',
            'message' => 'Income headers loaded successfully.',
            'data' => [
                'headers' => $headers,
                'categoryHeader' => $categoryHeader,
            ]
        ]);
    }

    public function udhyamData(Request $request)
    {
        try {
            if ($request->search) {
                $search = $request->search;
                $udhyamData = UdhyamData::when(!empty($request->filterData->provinces), function ($query) use ($request) {
                    $query->whereIn('province_id', $request->filterData->provinces);
                })->with(['district', 'province', 'localLevel', 'kaaryalaya', 'udhyamType', 'registrationType', 'udhyamFyData'])->get();
                $udhyamData = CollectionHelper::paginate($udhyamData->filter(function ($item) use ($search) {
                    return false !== stripos($item, $search);
                })->values(), $request->totalItems);
            } else {
                $filterData = json_decode($request->filterData);
                $udhyamData = UdhyamData::
                //Province
                when(!empty($filterData->provinces), function ($query) use ($filterData) {
                    $query->whereIn('province_id', $filterData->provinces);
                })
                    //District
                    ->when(!empty($filterData->districts), function ($query) use ($filterData) {
                        $query->whereIn('district_id', $filterData->districts);
                    })
                    //Local Level
                    ->when(!empty($filterData->localLevels), function ($query) use ($filterData) {
                        $query->whereIn('local_level_id', $filterData->localLevels);
                    })
                    //Ward
                    ->when(!empty($filterData->wards), function ($query) use ($filterData) {
                        $query->whereIn('ward', $filterData->wards);
                    })
                    //UdhyamType
                    ->when(!empty($filterData->udhyam_types), function ($query) use ($filterData) {
                        $query->whereIn('udhyam_type_id', $filterData->udhyam_types);
                    })
                    //RegistrationType
                    ->when(!empty($filterData->registration_types), function ($query) use ($filterData) {
                        $query->whereIn('registration_type_id', $filterData->registration_types);
                    })
                    ->with(['district', 'province', 'localLevel', 'kaaryalaya', 'udhyamType', 'registrationType', 'udhyamFyData'])->orderBy('created_at', 'desc')->paginate($request->totalItems);
            }
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data loaded successfully.',
                'data' => [
                    'udhyamData' => $udhyamData,
                    'totalUdhyamData' => $udhyamData['total'],
                ]
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function search(Request $request)
    {
        try {
            $cfData = CfData::with(['district', 'province', 'localLevel', 'physiography', 'subdivision', 'vegetationType', 'forestType', 'forestCondition'])->get();
            $paginatedData = CollectionHelper::paginate($cfData->where('district.name', 'Makwanpur'), $request->totalItems);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data loaded successfully.',
                'data' => [
                    'cfData' => $paginatedData,
                    'totalCfData' => $paginatedData['total'],
                ]
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveCfData(Request $request)
    {
        try {
            $cfDataFromFrontEnd = json_decode($request->cfData, true);
            // update
            if (isset($cfDataFromFrontEnd['id'])) {
                if (isset($request->fugAuditReports)) {
                    if ($fug_audit_reports = $request->file('fugAuditReports')) {
                        foreach ($fug_audit_reports as $file) {
                            $storedFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                            $originalFileName = $file->getClientOriginalName();
                            $file->move('storage/' . $cfDataFromFrontEnd['id'] . '/audit-reports' . '/', $storedFileName);
                            $fug_audit_report = new FugAuditReport();
                            $fug_audit_report->name = $originalFileName;
                            $fug_audit_report->file = $storedFileName;
                            $fug_audit_report->fug_id = $cfDataFromFrontEnd['id'];
                            $fug_audit_report->user_id = Auth::user()->id;
                            $fug_audit_report->save();
                        }
                    }
                }
                // save maps
                if (isset($request->maps)) {
                    if ($maps = $request->file('maps')) {
                        foreach ($maps as $file) {
                            $storedFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                            $originalFileName = $file->getClientOriginalName();
                            $file->move('storage/' . $cfDataFromFrontEnd['id'] . '/maps' . '/', $storedFileName);
                            $map = new FugMap();
                            $map->name = $originalFileName;
                            $map->file = $storedFileName;
                            $map->fug_id = $cfDataFromFrontEnd['id'];
                            $map->user_id = Auth::user()->id;
                            $map->save();
                        }
                    }
                }
                $cfData = CfData::find($cfDataFromFrontEnd['id']);
                $cfData->fug_name = $cfDataFromFrontEnd['fug_name'];
                $cfData->division_id = $cfDataFromFrontEnd['division_id'];
                $cfData->subdivision_id = $cfDataFromFrontEnd['subdivision_id'];
                $cfData->cfug_type_id = $cfDataFromFrontEnd['cfug_type_id'];
                $cfData->fug_code = $cfDataFromFrontEnd['fug_code'];
                $cfData->fug_pan_no = $cfDataFromFrontEnd['fug_pan_no'];
                $cfData->hh = $cfDataFromFrontEnd['hh'];
                $cfData->province_id = $cfDataFromFrontEnd['province_id'];
                $cfData->district_id = $cfDataFromFrontEnd['district_id'];
                $cfData->local_level_id = $cfDataFromFrontEnd['local_level_id'];
                $cfData->ward = $cfDataFromFrontEnd['ward'];
                $cfData->population = $cfDataFromFrontEnd['population'];
                $cfData->women_population = $cfDataFromFrontEnd['women_population'];
                $cfData->men_population = $cfDataFromFrontEnd['men_population'];
                $cfData->area_ha = $cfDataFromFrontEnd['area_ha'];
                $cfData->no_of_person_in_committee = $cfDataFromFrontEnd['no_of_person_in_committee'];
                $cfData->women_in_committee = $cfDataFromFrontEnd['women_in_committee'];
                $cfData->men_in_committee = $cfDataFromFrontEnd['men_in_committee'];
                $cfData->scientific_forest_approval_date = $cfDataFromFrontEnd['scientific_forest_approval_date'];
                $cfData->scientific_forest_area_ha = $cfDataFromFrontEnd['scientific_forest_area_ha'];
                $cfData->forest_based_industry_operations = $cfDataFromFrontEnd['forest_based_industry_operations'];
                $cfData->forest_based_tourism_operations = $cfDataFromFrontEnd['forest_based_tourism_operations'];
                $cfData->remarks = $cfDataFromFrontEnd['remarks'];
                $cfData->update();

                // soft deleting audit-report file
                $deletedAuditReports = json_decode($request->deletedAuditReports, true);
                if (count($deletedAuditReports) > 0) {
                    foreach ($deletedAuditReports as $item) {
                        $auditReport = FugAuditReport::find($item['id']);
                        $auditReport->delete();
                    }
                }

                // soft deleting map file
                $deletedMaps = json_decode($request->deletedMaps, true);
                if (count($deletedMaps) > 0) {
                    foreach ($deletedMaps as $item) {
                        $map = FugMap::find($item['id']);
                        $map->delete();
                    }
                }

                // deleting previous approval dates
                $approvalDates = FugApprovalDate::where('fug_id', $cfData['id'])->get();
                foreach ($approvalDates as $item) {
                    $item->delete();
                }
                // adding new approval dates
                foreach ($cfDataFromFrontEnd['fug_approval_dates'] as $item) {
                    $approvalDate = new FugApprovalDate();
                    $approvalDate->date = $item['date'];
                    $approvalDate->user_id = Auth::user()->id;
                    $approvalDate->fug_id = $cfData['id'];
                    $approvalDate->save();
                }

                return response([
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Data Updated successfully.'
                ]);
            }
            $fugData = CfData::create($cfDataFromFrontEnd);

            // adding new approval dates
            foreach ($cfDataFromFrontEnd['fug_approval_dates'] as $item) {
                $approvalDate = new FugApprovalDate();
                $approvalDate->date = $item['date'];
                $approvalDate->user_id = Auth::user()->id;
                $approvalDate->fug_id = $fugData->id;
                $approvalDate->save();
            }
            // fug audit reports creation
            if (isset($request->fugAuditReports)) {
                if ($fug_audit_reports = $request->file('fugAuditReports')) {
                    foreach ($fug_audit_reports as $file) {
                        $storedFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                        $originalFileName = $file->getClientOriginalName();
                        $file->move('storage/' . $fugData->id . '/audit-reports' . '/', $storedFileName);
                        $fug_audit_report = new FugAuditReport();
                        $fug_audit_report->name = $originalFileName;
                        $fug_audit_report->file = $storedFileName;
                        $fug_audit_report->fug_id = $fugData->id;
                        $fug_audit_report->user_id = Auth::user()->id;
                        $fug_audit_report->save();
                    }
                }
            }

            // fug map creation
            // save maps
            if (isset($request->maps)) {
                if ($maps = $request->file('maps')) {
                    foreach ($maps as $file) {
                        $storedFileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                        $originalFileName = $file->getClientOriginalName();
                        $file->move('storage/' . $fugData->id . '/maps' . '/', $storedFileName);
                        $map = new FugMap();
                        $map->name = $originalFileName;
                        $map->file = $storedFileName;
                        $map->fug_id = $fugData->id;
                        $map->user_id = Auth::user()->id;
                        $map->save();
                    }
                }
            }
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data Created successfully.'
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveUdhyamData(Request $request)
    {
        try {
            $udhyamDataFromFrontend = $request->all();
            // update
            if (isset($udhyamDataFromFrontend['id'])) {
                $udhyamData = UdhyamData::find($request['id']);
                $udhyamData->kaaryalaya_id = $udhyamDataFromFrontend['kaaryalaya_id'];
                $udhyamData->udhyam_name = $udhyamDataFromFrontend['udhyam_name'];
                $udhyamData->udhyam_type_id = $udhyamDataFromFrontend['udhyam_type_id'];
                $udhyamData->pan_vat_no = $udhyamDataFromFrontend['pan_vat_no'];
                $udhyamData->registration_type_id = $udhyamDataFromFrontend['registration_type_id'];
                $udhyamData->registration_no = $udhyamDataFromFrontend['registration_no'];
                $udhyamData->registration_date = $udhyamDataFromFrontend['registration_date'];
                $udhyamData->province_id = $udhyamDataFromFrontend['province_id'];
                $udhyamData->district_id = $udhyamDataFromFrontend['district_id'];
                $udhyamData->local_level_id = $udhyamDataFromFrontend['local_level_id'];
                $udhyamData->ward = $udhyamDataFromFrontend['ward'];
                $udhyamData->update();

                return response([
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Data Updated successfully.'
                ]);
            }
            $udhyamData = UdhyamData::create($udhyamDataFromFrontend);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data Created successfully.'
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveUdhyamFyData(Request $request)
    {
        try {
            $udhyamDataFyFromFrontend = $request->all();
            // update
            if (isset($udhyamDataFyFromFrontend['id'])) {
                $udhyamDataFy = UdhyamFyData::find($request['id']);
                $udhyamDataFy->udhyam_id = $udhyamDataFyFromFrontend['udhyam_id'];
                $udhyamDataFy->aarthik_barsa_id = $udhyamDataFyFromFrontend['aarthik_barsa_id'];
                $udhyamDataFy->pratakchya_rojgari = $udhyamDataFyFromFrontend['pratakchya_rojgari'];
                $udhyamDataFy->apratakchya_rojgari = $udhyamDataFyFromFrontend['apratakchya_rojgari'];
                $udhyamDataFy->punji = $udhyamDataFyFromFrontend['punji'];
                $udhyamDataFy->update();

                return response([
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Data Updated successfully.'
                ]);
            }
            $udhyamDataFy = UdhyamFyData::create($udhyamDataFyFromFrontend);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data Created successfully.'
            ]);
        }
        catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveFugFyData(Request $request)
    {
        try {
            $fugDataFyFromFrontend = $request->all();
            // update
            if (isset($fugDataFyFromFrontend['id'])) {
                $fugDataFy = CfFyData::find($request['id']);
                $fugDataFy->hh = $fugDataFyFromFrontend['hh'];
                $fugDataFy->population = $fugDataFyFromFrontend['population'];
                $fugDataFy->women_population = $fugDataFyFromFrontend['women_population'];
                $fugDataFy->men_population = $fugDataFyFromFrontend['men_population'];
                $fugDataFy->no_of_person_in_committee = $fugDataFyFromFrontend['no_of_person_in_committee'];
                $fugDataFy->women_in_committee = $fugDataFyFromFrontend['women_in_committee'];
                $fugDataFy->men_in_committee = $fugDataFyFromFrontend['men_in_committee'];
                $fugDataFy->forest_based_industry_operations = $fugDataFyFromFrontend['forest_based_industry_operations'];
                $fugDataFy->forest_based_tourism_operations = $fugDataFyFromFrontend['forest_based_tourism_operations'];
                $fugDataFy->update();

                return response([
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Data Updated successfully.'
                ]);
            }
            $fugDataFy = CfFyData::create($fugDataFyFromFrontend);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data Created successfully.'
            ]);
        }
        catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getUdhyamFyData(Request $request){
        try {
            $aarthik_barsa_id = $request->aarthikBarsa;
            $udhyam_id = $request->udhyam;
            $id = $request->id;

             $udhyamFyData = UdhyamFyData::find($id);
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'data' => compact('udhyamFyData')
                ]
            );
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getFugFyData(Request $request){
        try {
            $aarthik_barsa_id = $request->aarthikBarsa;
            $fug_id = $request->fug;
            $id = $request->id;

            $fugFyData = CfFyData::find($id);
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'data' => compact('fugFyData')
                ]
            );
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteUdhyamData(Request $request)
    {
        try {
            UdhyamData::destroy($request->id);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteCfData(Request $request)
    {
        try {
            CfData::destroy($request->id);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveFugApprovalDate(Request $request)
    {
        try {
            $requestData = $request->data;
            if ($requestData['id']) {
                // update
            }
            $fugApprovalDate = new FugApprovalDate();
            $fugApprovalDate->date = $requestData['date'];
            $fugApprovalDate->user_id = $requestData['user_id'];
            $fugApprovalDate->fug_id = $requestData['fug_id'];
            $fugApprovalDate->save();

            return response([
                'status' => 200,
                'type' => 'success',
                'data' => compact('fugApprovalDate'),
                'message' => 'Data Approved successfully.'
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function loadResources(Request $request)
    {
        try {
            $provinces = Province::with('districts.localLevels')->get();
            $subdivisions = SubDivision::orderBy('name')->get();
            $divisions = Division::orderBy('name')->get();
            $physiographies = Physiography::orderBy('name')->get();
            $vegetation_types = VegetationType::orderBy('code')->get();
            $forest_types = ForestType::orderBy('name')->get();
            $cfug_types = CfugType::orderBy('name')->get();
            $forest_conditions = ForestCondition::orderBy('code')->get();
            $localLevelWithWard = CfData::select('local_level_id', 'ward')->get();
            $kharchaCategories = KharchaCategory::with('kharcha_types')->select('id', 'title', 'order')->get();
            $aarthikBarsas = AarthikBarsa::select('id', 'name')->get();
            $cfugs = CfData::select('id', 'fug_name')->get();
            $udhyams = UdhyamData::select('id', 'udhyam_name')->get();
            $incomeCategories = IncomeCategory::with('income_types')->select('id', 'title', 'order')->get();
            $roles = Role::all();
            $permissions = Permission::all();
            $kaaryalaya = Kaaryalaya::all();
            $udhyam_types = UdhyamType::all();
            $registration_types = RegistrationType::all();
            $userPermissions = $this->permissions();
            $formattedPermissions = $this->formattedPermissions();
            $dashboard_items = [
                0 => [
                    'title' => '???????????? ???????????????',
                    'subTitle' => '????????? ???????????? ???????????????????????? ??????????????????',
                    'count' => $this->englishToNepali(number_format(CfData::all()->count())),
                    'lastEntry' => CfData::orderBy('created_at', 'desc')->first() ? CfData::orderBy('created_at', 'desc')->first()->created_at->diffForHumans() : '',
                ],
                1 => [
                    'title' => '??????????????????????????????????????????',
                    'subTitle' => '????????? ??????????????????????????????????????????????????? ??????????????????',
                    'count' => $this->englishToNepali(number_format(User::all()->count())),
                    'lastEntry' => User::orderBy('created_at', 'desc')->first() ? User::orderBy('created_at', 'desc')->first()->created_at->diffForHumans() : '',
                ],
                2 => [
                    'title' => '???????????????????????????',
                    'subTitle' => '????????? ???????????????????????????????????? ??????????????????',
                    'count' => $this->englishToNepali(number_format(Role::all()->count())),
                    'lastEntry' => Role::orderBy('created_at', 'desc')->first() ? Role::orderBy('created_at', 'desc')->first()->created_at->diffForHumans() : '',
                ],
                3 => [
                    'title' => '???????????????????????????',
                    'subTitle' => '????????? ???????????????????????????????????? ??????????????????',
                    'count' => $this->englishToNepali(number_format(Permission::all()->count())),
                    'lastEntry' => Permission::orderBy('created_at', 'desc')->first() ? Permission::orderBy('created_at', 'desc')->first()->created_at->diffForHumans() : '',
                ],
            ];
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Resources loaded successfully',
                'data' => compact('divisions', 'cfug_types', 'kaaryalaya', 'formattedPermissions', 'provinces', 'subdivisions', 'physiographies', 'vegetation_types', 'forest_types', 'forest_conditions', 'roles', 'permissions', 'localLevelWithWard', 'dashboard_items', 'userPermissions', 'incomeCategories', 'kharchaCategories', 'cfugs','udhyams', 'aarthikBarsas', 'udhyam_types', 'registration_types')
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function permissions()
    {
        $user = Auth::user();
        $permissions = [];
        $additionalPermissions = collect($user->permissions);
        $roles = $user->roles;
        foreach ($additionalPermissions as $permission) {
            array_push($permissions, $permission->name);
        }
        foreach ($roles as $role) {
            foreach ($role->permissions as $rolePermission) {
                array_push($permissions, $rolePermission->name);
            }
        }

        return $permissions;
    }

    private function formattedPermissions()
    {
        $permissions = Permission::orderBy('name')->get();
        $formattedPermissions = [];
        foreach ($permissions as $item) {
            $key = explode('-', $item->name)[0];
            $formattedPermissions[$key][] = $item;
        }
        return $formattedPermissions;
    }

    private function englishToNepali($j)
    {
        $find = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $replace = array("???", "???", "???", "???", "???", "???", "???", "???", "???", "???");

        // number lai array ma lageko
        $numarr = str_split($j, 1);

        // numarr ko value lai nepali ma replace garna ko lagi, yesle array fyalxa
        $num = str_replace($find, $replace, $numarr);

        // yesle array linxa ani string return garxa
        return implode($num);
    }
}
