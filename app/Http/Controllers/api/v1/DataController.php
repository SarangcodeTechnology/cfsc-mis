<?php

namespace App\Http\Controllers\api\v1\api\v1;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\api\v1\Controller;
use App\Models\CfData;
use App\Models\ForestCondition;
use App\Models\ForestType;
use App\Models\FugApprovalDate;
use App\Models\FugAuditReport;
use App\Models\FugMap;
use App\Models\Permission;
use App\Models\Physiography;
use App\Models\Province;
use App\Models\Role;
use App\Models\SubDivision;
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
                })->with(['district', 'province', 'localLevel','fug_approval_dates','fug_audit_reports','fug_maps'])->get();
                $cfData = CollectionHelper::paginate($cfData->filter(function ($item) use ($search) {
                    return false !== stripos($item, $search);
                })->values(), $request->totalItems);
            } else {
                $filterData = json_decode($request->filterData);
                $cfData = CfData::
                //Province
                    when(!empty($filterData->provinces), function($query) use ($filterData){
                        $query->whereIn('province_id',$filterData->provinces);
                })
                //District
                    ->when(!empty($filterData->districts),function($query) use ($filterData){
                        $query->whereIn('district_id',$filterData->districts);
                })
                //Local Level
                    ->when(!empty($filterData->localLevels),function($query) use ($filterData){
                        $query->whereIn('local_level_id',$filterData->localLevels);
                    })
                //Ward
                    ->when(!empty($filterData->wards),function ($query) use ($filterData){
                        $query->whereIn('ward',$filterData->wards);
                })
                //Area HA
                    ->when($filterData->areaHa->from!=0 || $filterData->areaHa->to!=0, function($query) use ($filterData){
                        $query->where('area_ha','>=',(int)$filterData->areaHa->from)->where('area_ha','<=',(int)$filterData->areaHa->to);
                } )
                //HH
                    ->when($filterData->hh->from!=0 || $filterData->hh->to!=0, function($query) use ($filterData){
                        $query->where('hh','>=',(int)$filterData->hh->from)->where('hh','<=',(int)$filterData->hh->to);
                } )
                //Total Population
                    ->when($filterData->totalPopulation->from!=0 || $filterData->totalPopulation->to!=0, function($query) use ($filterData){
                        $query->where('population','>=',(int)$filterData->totalPopulation->from)->where('population','<=',(int)$filterData->totalPopulation->to);
                } )
                //Men Population
                    ->when($filterData->menPopulation->from!=0 || $filterData->menPopulation->to!=0, function($query) use ($filterData){
                        $query->where('men_population','>=',(int)$filterData->menPopulation->from)->where('men_population','<=',(int)$filterData->menPopulation->to);
                } )
                //Women Population
                    ->when($filterData->womenPopulation->from!=0 || $filterData->womenPopulation->to!=0, function($query) use ($filterData){
                        $query->where('women_population','>=',(int)$filterData->womenPopulation->from)->where('women_population','<=',(int)$filterData->womenPopulation->to);
                } )
                //Total Person in Committee
                    ->when($filterData->numberOfPersonInCommittee->from!=0 || $filterData->numberOfPersonInCommittee->to!=0, function($query) use ($filterData){
                        $query->where('no_of_person_in_committee','>=',(int)$filterData->numberOfPersonInCommittee->from)->where('no_of_person_in_committee','<=',(int)$filterData->numberOfPersonInCommittee->to);
                } )
                //Men in Committee
                    ->when($filterData->menInCommittee->from!=0 || $filterData->menInCommittee->to!=0, function($query) use ($filterData){
                        $query->where('men_in_committee','>=',(int)$filterData->menInCommittee->from)->where('men_in_committee','<=',(int)$filterData->menInCommittee->to);
                } )
                //Women in Committee
                    ->when($filterData->womenInCommittee->from!=0 || $filterData->womenInCommittee->to!=0, function($query) use ($filterData){
                        $query->where('women_in_committee','>=',(int)$filterData->womenInCommittee->from)->where('women_in_committee','<=',(int)$filterData->womenInCommittee->to);
                } )

                    ->with(['district', 'province', 'localLevel','fug_approval_dates','fug_audit_reports','fug_maps'])->orderBy('created_at','desc')->paginate($request->totalItems);
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

    public function saveCfData(Request $request){
        try {
            $cfDataFromFrontEnd = json_decode($request->cfData,true);
            // update
            if(isset($cfDataFromFrontEnd['id'])){
                if(isset($request->fugAuditReports)){
                    if($fug_audit_reports=$request->file('fugAuditReports')){
                        foreach($fug_audit_reports as $file){
                            $storedFileName = Str::random(20).'.'.$file->getClientOriginalExtension();
                            $originalFileName = $file->getClientOriginalName();
                            $file->move('storage/'.$cfDataFromFrontEnd['id'].'/audit-reports'.'/',$storedFileName);
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
                if(isset($request->maps)){
                    if($maps=$request->file('maps')){
                        foreach($maps as $file){
                            $storedFileName = Str::random(20).'.'.$file->getClientOriginalExtension();
                            $originalFileName = $file->getClientOriginalName();
                            $file->move('storage/'.$cfDataFromFrontEnd['id'].'/maps'.'/',$storedFileName);
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
                $cfData->fug_code = $cfDataFromFrontEnd['fug_code'];
                $cfData->fug_pan_no = $cfDataFromFrontEnd['fug_pan_no'];
                $cfData->hh = $cfDataFromFrontEnd['hh'];
                $cfData->province_id = $cfDataFromFrontEnd['province_id'];
                $cfData->district_id = $cfDataFromFrontEnd['district_id'];
                $cfData->local_level_id = $cfDataFromFrontEnd['local_level_id'];
                $cfData->ward = $cfDataFromFrontEnd['ward'];
                $cfData->population = $cfDataFromFrontEnd['population'];
                $cfData->women_population = $cfDataFromFrontEnd['women_population'];
                $cfData->men_population  = $cfDataFromFrontEnd['men_population'];
                $cfData->area_ha = $cfDataFromFrontEnd['area_ha'];
                $cfData->no_of_person_in_committee = $cfDataFromFrontEnd['no_of_person_in_committee'];
                $cfData->women_in_committee = $cfDataFromFrontEnd['women_in_committee'];
                $cfData->men_in_committee = $cfDataFromFrontEnd['men_in_committee'];
                $cfData->scientific_forest_approval_date =  $cfDataFromFrontEnd['scientific_forest_approval_date'];
                $cfData->scientific_forest_area_ha = $cfDataFromFrontEnd['scientific_forest_area_ha'];
                $cfData->forest_based_industry_operations = $cfDataFromFrontEnd['forest_based_industry_operations'];
                $cfData->forest_based_tourism_operations = $cfDataFromFrontEnd['forest_based_tourism_operations'];
                $cfData->remarks = $cfDataFromFrontEnd['remarks'];
                $cfData->update();

                // soft deleting audit-report file
                $deletedAuditReports = json_decode($request->deletedAuditReports,true);
                if(count($deletedAuditReports)>0){
                    foreach($deletedAuditReports as $item){
                        $auditReport = FugAuditReport::find($item['id']);
                        $auditReport->delete();
                    }
                }

                // soft deleting map file
                $deletedMaps = json_decode($request->deletedMaps,true);
                if(count($deletedMaps)>0){
                    foreach($deletedMaps as $item){
                        $map = FugMap::find($item['id']);
                        $map->delete();
                    }
                }

                // deleting previous approval dates
                $approvalDates = FugApprovalDate::where('fug_id',$cfData['id'])->get();
                foreach($approvalDates as $item){
                    $item->delete();
                }
                // adding new approval dates
                foreach($cfDataFromFrontEnd['fug_approval_dates'] as $item){
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
            foreach($cfDataFromFrontEnd['fug_approval_dates'] as $item){
                $approvalDate = new FugApprovalDate();
                $approvalDate->date = $item['date'];
                $approvalDate->user_id = Auth::user()->id;
                $approvalDate->fug_id = $fugData->id;
                $approvalDate->save();
            }
            // fug audit reports creation
            if(isset($request->fugAuditReports)){
                if($fug_audit_reports=$request->file('fugAuditReports')){
                    foreach($fug_audit_reports as $file){
                        $storedFileName = Str::random(20).'.'.$file->getClientOriginalExtension();
                        $originalFileName = $file->getClientOriginalName();
                        $file->move('storage/'.$fugData->id.'/audit-reports'.'/',$storedFileName);
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
            if(isset($request->maps)){
                if($maps=$request->file('maps')){
                    foreach($maps as $file){
                        $storedFileName = Str::random(20).'.'.$file->getClientOriginalExtension();
                        $originalFileName = $file->getClientOriginalName();
                        $file->move('storage/'.$fugData->id.'/maps'.'/',$storedFileName);
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

    public function deleteCfData(Request $request){
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

    public function saveFugApprovalDate(Request $request){
        try{
            $requestData = $request->data;
            if($requestData['id']){
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
        }
        catch(Exception $e){
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
            $physiographies = Physiography::orderBy('name')->get();
            $vegetation_types = VegetationType::orderBy('code')->get();
            $forest_types = ForestType::orderBy('name')->get();
            $forest_conditions = ForestCondition::orderBy('code')->get();
            $localLevelWithWard = CfData::select('local_level_id','ward')->get();
            $roles = Role::all();
            $permissions = Permission::all();
            $userPermissions = $this->permissions();
            $dashboard_items = [
                0 => [
                    'title' => 'सामुदायिक वन विवरण',
                    'subTitle' => 'कुल सामुदायिक वन विवरणकाे संख्या',
                    'count' => $this->englishToNepali(number_format(CfData::all()->count())),
                    'lastEntry' => CfData::orderBy('created_at','desc')->first() ? CfData::orderBy('created_at','desc')->first()->created_at->diffForHumans() : '' ,
                ],
                1 => [
                    'title' => 'प्रयोगकर्ताहरू',
                    'subTitle' => 'कुल प्रयोगकर्ताहरूकाे संख्या',
                    'count' => $this->englishToNepali(number_format(User::all()->count())),
                    'lastEntry' => User::orderBy('created_at','desc')->first() ? User::orderBy('created_at','desc')->first()->created_at->diffForHumans() : '' ,
                ],
                2 => [
                    'title' => 'भूमिकाहरू',
                    'subTitle' => 'कुल भूमिकाहरूकाे संख्या',
                    'count' => $this->englishToNepali(number_format(Role::all()->count())),
                    'lastEntry' => Role::orderBy('created_at','desc')->first() ? Role::orderBy('created_at','desc')->first()->created_at->diffForHumans() : '' ,
                ],
                3 => [
                    'title' => 'अनुमतिहरू',
                    'subTitle' => 'कुल अनुमतिहरूकाे संख्या',
                    'count' => $this->englishToNepali(number_format(Permission::all()->count())),
                    'lastEntry' => Permission::orderBy('created_at','desc')->first() ? Permission::orderBy('created_at','desc')->first()->created_at->diffForHumans() : '' ,
                ],
            ];
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Resources loaded successfully',
                'data' => compact('provinces','subdivisions','physiographies','vegetation_types','forest_types','forest_conditions','roles','permissions','localLevelWithWard','dashboard_items','userPermissions')
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
    private function englishToNepali($j){
        $find = array("1","2","3","4","5","6","7","8","9","0");
        $replace = array("१","२","३","४","५","६","७","८","९","०");

        // number lai array ma lageko
        $numarr = str_split($j,1);

        // numarr ko value lai nepali ma replace garna ko lagi, yesle array fyalxa
        $num = str_replace($find,$replace,$numarr);

        // yesle array linxa ani string return garxa
        return implode($num);
    }
    private function permissions(){
        $user = Auth::user();
        $permissions = [];
        $additionalPermissions =  collect($user->permissions);
        $roles = $user->roles;
        foreach($additionalPermissions as $permission){
            array_push($permissions, $permission->name);
        }
        foreach($roles as $role){
            foreach($role->permissions as $rolePermission){
                array_push($permissions, $rolePermission->name);
            }
        }

        return $permissions;
    }
}
