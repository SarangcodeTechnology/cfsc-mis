<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kharcha;
use App\Models\KharchaCategory;
use Exception;
use Illuminate\Http\Request;

class KharchaController extends Controller
{
    public function index()
    {
        try {
            $kharcha = Kharcha::orderBy('created_at', 'desc')->get();
            $test='[
  {
      "id": 1,
    "created_at": "2021-06-05T00:00:00.000000Z",
    "updated_at": "2021-06-05T00:00:00.000000Z",
    "title": "Category 1",
    "order": 1,
    "kharcha_types": [
      {
          "id": 1,
        "created_at": "2021-06-05T16:18:20.000000Z",
        "updated_at": "2021-06-05T16:18:20.000000Z",
        "title": "Type 1 - Cat 1",
        "kharcha_category_id": 1,
        "order": 1,
        "kharcha": 200,
        "kaifiyat": "test remarks 1"
      },
      {
          "id": 2,
        "created_at": "2021-06-05T16:19:00.000000Z",
        "updated_at": "2021-06-05T16:19:00.000000Z",
        "title": "Type 2 - Cat 1",
        "kharcha_category_id": 1,
        "order": 2,
        "kharcha": 200,
        "kaifiyat": "test remarks 2"
      }
    ]
  },
  {
      "id": 2,
    "created_at": "2021-06-05T00:00:00.000000Z",
    "updated_at": "2021-06-05T00:00:00.000000Z",
    "title": "Category 2",
    "order": 1,
    "kharcha_types": [
      {
          "id": 1,
        "created_at": "2021-06-05T16:18:20.000000Z",
        "updated_at": "2021-06-05T16:18:20.000000Z",
        "title": "Type 1 - Cat 2",
        "kharcha_category_id": 1,
        "order": 1,
        "kharcha": 200,
        "kaifiyat": "test remarks 3"
      },
      {
          "id": 2,
        "created_at": "2021-06-05T16:19:00.000000Z",
        "updated_at": "2021-06-05T16:19:00.000000Z",
        "title": "Type 2 - Cat 2",
        "kharcha_category_id": 1,
        "order": 2,
        "kharcha": 200,
        "kaifiyat": "test remarks 4"
      }
    ]
  }
]';
            $kharcha=json_decode($test);
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
