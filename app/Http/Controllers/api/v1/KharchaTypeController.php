<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\KharchaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class KharchaTypeController extends Controller
{
    public function index(){
        try{
            $kharchaTypes = KharchaType::with('kharchaCategory')->orderBy('created_at','desc')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Kharcha Type loaded successfully',
                    'data' => compact('kharchaTypes')
                ]
            );
        }
        catch(Exception $e){
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function saveKharchaType(Request $request){
        try{
            // update
            if(isset($request->data['id'])){
                $kharchaType = KharchaType::find($request->data['id']);
                $kharchaType->title = $request->data['title'];
                $kharchaType->kharcha_category_id = $request->data['kharcha_category_id'];
                $kharchaType->order = $request->data['order'];
                $kharchaType->update();
                $saved=0;
            }
            // create
            else{
                $kharchaType = new KharchaType();
                $kharchaType->title = $request->data['title'];
                $kharchaType->kharcha_category_id = $request->data['kharcha_category_id'];
                $kharchaType->order = $request->data['order'];
                $kharchaType->save();
                $saved = 1;
            }

            return response(
                [
                    'status'=>200,
                    'type'=>'success',
                    'message' => 'Kharcha Type '.($saved ? 'created' : 'updated').' successfully',
                ]
            );
        }
        catch(Exception $e){
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteKharchaType(Request $request)
    {
        try {
            KharchaType::destroy($request['data']['id']);
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
}
