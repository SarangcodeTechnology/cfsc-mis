<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(){
        try{
            $income = Income::orderBy('created_at','desc')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Income  loaded successfully',
                    'data' => compact('income')
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
    public function saveIncome(Request $request){
        try{
            // update
            if(isset($request->data['id'])){
                $income = Income::find($request->data['id']);
                $income->title = $request->data['title'];
                $income->order = $request->data['order'];
                $income->update();
                $saved=0;
            }
            // create
            else{
                $income = new Income();
                $income->title = $request->data['title'];
                $income->order = $request->data['order'];
                $income->save();
                $saved = 1;
            }

            return response(
                [
                    'status'=>200,
                    'type'=>'success',
                    'message' => 'Income  '.($saved ? 'created' : 'updated').' successfully',
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
}
