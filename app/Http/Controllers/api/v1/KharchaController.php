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
    public function index()
    {
        try {
            $i = 0;
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
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Kharcha loaded successfully',
                    'data' => compact('kharcha')
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
