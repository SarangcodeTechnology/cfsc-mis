<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AarthikBarsa;
use App\Models\KharchaCategory;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class KharchaCategoryController extends Controller
{
    public function index(){
        try{
            $kharchaCategories = KharchaCategory::orderBy('created_at','desc')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Kharcha Category loaded successfully',
                    'data' => compact('kharchaCategories')
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
    public function saveKharchaCategory(Request $request){
        try{
            // update
            if(isset($request->data['id'])){
                $kharchaCategory = KharchaCategory::find($request->data['id']);
                $kharchaCategory->title = $request->data['title'];
                $kharchaCategory->order = $request->data['order'];
                $kharchaCategory->update();
                $saved=0;
            }
            // create
            else{
                $kharchaCategory = new KharchaCategory();
                $kharchaCategory->title = $request->data['title'];
                $kharchaCategory->order = $request->data['order'];
                $kharchaCategory->save();
                $saved = 1;
            }

            return response(
                [
                    'status'=>200,
                    'type'=>'success',
                    'message' => 'Kharcha Category '.($saved ? 'created' : 'updated').' successfully',
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

    public function deleteKharchaCategory(Request $request)
    {
        try {
            KharchaCategory::destroy($request['data']['id']);
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
