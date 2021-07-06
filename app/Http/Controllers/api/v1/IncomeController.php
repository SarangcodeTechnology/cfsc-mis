<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AarthikBarsa;
use App\Models\CfData;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $i = 0;
            $income = [];
            foreach(Income::select('fug_id','aarthik_barsa_id')->distinct()->get() as $item){
                $aarthik_barsa_id = $item->aarthik_barsa_id;
                $fug_id = $item->fug_id;
                $income[$i]['aarthik_barsa'] = AarthikBarsa::find($aarthik_barsa_id);
                $income[$i]['fug'] = CfData::find($fug_id);
                $income[$i]['items'] = IncomeCategory::with(['income_types'=>function($query) use ($aarthik_barsa_id,$fug_id){
                    $query->with('income',function($incomeQuery) use ($aarthik_barsa_id,$fug_id){
                        $incomeQuery->where('aarthik_barsa_id',$aarthik_barsa_id)->where('fug_id',$fug_id);
                    });
                }])->get();
                $i++;
            }
            $filterData = json_decode($request->filterData);
            $aarthik_barsa_ids = $filterData->aarthikBarsaIds;
            $fug_ids = $filterData->cfugIds;
            $incomeCollection  = collect($income);
            $income = $incomeCollection->when(!empty($aarthik_barsa_ids),function($query) use ($aarthik_barsa_ids){
                return $query->whereIn('aarthik_barsa.id',$aarthik_barsa_ids);
            })->when(!empty($fug_ids),function($query) use ($fug_ids){
                return $query->whereIn('fug.id',$fug_ids);
            })->values();

            $csvData = $this->makeCsvData($income);

            $headers = [
                ['text' => "कार्यहरु", 'value'=> "actions"],
                ['text' => "वन उपभाेक्ता समूह", 'value'=> "fug.fug_name"],
                ['text' => "आर्थिक वर्ष", 'value'=> "aarthik_barsa.name"],
            ];
            $categoryHeader = [];

            foreach(IncomeCategory::all() as $itemKey=>$item){
                $colspan = 0;
                foreach($item->income_types as $subItemKey=>$subItem){
                    $data['text'] = $subItem->title;
                    $data['value'] = "items[{$itemKey}].income_types[{$subItemKey}].income.jamma";
                    array_push($headers,$data);
                    $colspan++;
                }
                $categoryData['title'] = $item->title;
                $categoryData['colspan'] = $colspan;
                if($colspan) array_push($categoryHeader,$categoryData);
            }

            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Income loaded successfully',
                    'data' => compact('income','csvData','headers','categoryHeader')
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

    public function makeCsvData($income){
        $csvData = [];
        foreach($income as $incomeKey=>$incomeItem){
            $csvData[$incomeKey]['वन उपभाेक्ता समूह'] = optional($incomeItem['fug'])['fug_name'];
            $csvData[$incomeKey]['आर्थिक वर्ष'] = $incomeItem['aarthik_barsa']['name'];
            foreach(IncomeCategory::all() as $categoryKey=>$categoryItem){
                foreach($categoryItem->income_types as $typeKey=>$typeItem){
                    $csvData[$incomeKey][$typeItem->title] = $incomeItem['items'][$categoryKey]['income_types'][$typeKey]['income'] ? $incomeItem['items'][$categoryKey]['income_types'][$typeKey]['income']['jamma'] : '';
                }
            }
        }
        return $csvData;
    }

    public function saveIncomeData(Request $request)
    {
        try {
            $items = $request->items;
            foreach($items as $item){
                // update
                if (isset($item['id'])) {
                    $income = Income::find($item['id'])->update($item);

                } // create
                else {
                    Income::create($item);
                }
            }


            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Income Updated successfully',
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

    public function deleteIncome(Request $request)
    {
        try {
            Income::destroy($request['data']['id']);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Item Deleted Successfully ',
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getIncomeData(Request $request){
        try {
            $aarthik_barsa_id = $request->aarthikBarsa;
            $fug_id = $request->cfug;

            $incomeData = IncomeCategory::with(['income_types'=>function($query) use ($aarthik_barsa_id,$fug_id){
                $query->with('income',function($incomeQuery) use ($aarthik_barsa_id,$fug_id){
                    $incomeQuery->where('aarthik_barsa_id',$aarthik_barsa_id)->where('fug_id',$fug_id);
                });
            }])->whereHas('income_types')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'data' => compact('incomeData')
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
}
