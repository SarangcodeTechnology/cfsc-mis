<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AarthikBarsa;
use App\Models\CfData;
use App\Models\Kharcha;
use App\Models\KharchaCategory;
use Exception;
use Illuminate\Http\Request;

class KharchaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $i = 0;
            $kharcha =[];
            foreach(Kharcha::select('fug_id','aarthik_barsa_id')->distinct()->get() as $item){
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
            $filterData = json_decode($request->filterData);
            $aarthik_barsa_ids = $filterData->aarthikBarsaIds;
            $fug_ids = $filterData->cfugIds;
            $kharchaCollection  = collect($kharcha);
            $kharcha = $kharchaCollection->when(!empty($aarthik_barsa_ids),function($query) use ($aarthik_barsa_ids){
                return $query->whereIn('aarthik_barsa.id',$aarthik_barsa_ids);
            })->when(!empty($fug_ids),function($query) use ($fug_ids){
                return $query->whereIn('fug.id',$fug_ids);
            })->values();
            $csvData = $this->makeCsvData($kharcha);
            $headers = [
                ['text' => "कार्यहरु", 'value'=> "actions"],
                ['text' => "वन उपभाेक्ता समूह", 'value'=> "fug.fug_name"],
                ['text' => "आर्थिक वर्ष", 'value'=> "aarthik_barsa.name"],
            ];
            $categoryHeader = [];
            foreach(KharchaCategory::all() as $itemKey=>$item){
                $colspan = 0;
                foreach($item->kharcha_types as $subItemKey=>$subItem){
                    $data['text'] = $subItem->title;
                    $data['value'] = "items[{$itemKey}].kharcha_types[{$subItemKey}].kharcha.jamma";
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
                    'message' => 'Kharcha loaded successfully',
                    'data' => compact('kharcha','csvData','headers','categoryHeader')
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

    public function makeCsvData($kharcha){
        $csvData = [];
        foreach($kharcha as $kharchaKey=>$kharchaItem){
            $csvData[$kharchaKey]['वन उपभाेक्ता समूह'] = $kharchaItem['fug']['fug_name'];
            $csvData[$kharchaKey]['आर्थिक वर्ष'] = $kharchaItem['aarthik_barsa']['name'];
            foreach(KharchaCategory::all() as $categoryKey=>$categoryItem){
                foreach($categoryItem->kharcha_types as $typeKey=>$typeItem){
                    $csvData[$kharchaKey][$typeItem->title] = $kharchaItem['items'][$categoryKey]['kharcha_types'][$typeKey]['kharcha'] ? $kharchaItem['items'][$categoryKey]['kharcha_types'][$typeKey]['kharcha']['jamma'] : '';
                }
            }
        }
        return $csvData;
    }

    public function saveKharchaData(Request $request)
    {
        try {
            $items = $request->items;
            foreach($items as $item){
                // update
                if (isset($item['id'])) {
                    $kharcha = Kharcha::find($item['id'])->update($item);

                } // create
                else {
                    Kharcha::create($item);
                }
            }


            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Kharcha Updated successfully',
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

    public function deleteKharcha(Request $request)
    {
        try {
            Kharcha::destroy($request['data']['id']);
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

    public function getKharchaData(Request $request){
        try {
            $aarthik_barsa_id = $request->aarthikBarsa;
            $fug_id = $request->cfug;

            $kharchaData = KharchaCategory::with(['kharcha_types'=>function($query) use ($aarthik_barsa_id,$fug_id){
                $query->with('kharcha',function($kharchaQuery) use ($aarthik_barsa_id,$fug_id){
                    $kharchaQuery->where('aarthik_barsa_id',$aarthik_barsa_id)->where('fug_id',$fug_id);
                });
            }])->whereHas('kharcha_types')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'data' => compact('kharchaData')
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
