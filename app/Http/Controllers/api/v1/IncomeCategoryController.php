<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function index(){
        try{
            $incomeCategories = IncomeCategory::orderBy('created_at','desc')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Income Category loaded successfully',
                    'data' => compact('incomeCategories')
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
    public function saveIncomeCategory(Request $request){
        try{
            // update
            if(isset($request->data['id'])){
                $incomeCategory = IncomeCategory::find($request->data['id']);
                $incomeCategory->title = $request->data['title'];
                $incomeCategory->order = $request->data['order'];
                $incomeCategory->update();
                $saved=0;
            }
            // create
            else{
                $incomeCategory = new IncomeCategory();
                $incomeCategory->title = $request->data['title'];
                $incomeCategory->order = $request->data['order'];
                $incomeCategory->save();
                $saved = 1;
            }

            return response(
                [
                    'status'=>200,
                    'type'=>'success',
                    'message' => 'Income Category '.($saved ? 'created' : 'updated').' successfully',
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

    public function deleteIncomeCategory(Request $request)
    {
        try {
            IncomeCategory::destroy($request['data']['id']);
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
