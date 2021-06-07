<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\IncomeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class IncomeTypeController extends Controller
{
    public function index(){
        try{
            $incomeTypes = IncomeType::orderBy('created_at','desc')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Income Type loaded successfully',
                    'data' => compact('incomeTypes')
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
    public function saveIncomeType(Request $request){
        try{
            // update
            if(isset($request->data['id'])){
                $incomeType = IncomeType::find($request->data['id']);
                $incomeType->title = $request->data['title'];
                $incomeType->order = $request->data['order'];
                $incomeType->update();
                $saved=0;
            }
            // create
            else{
                $incomeType = new IncomeType();
                $incomeType->title = $request->data['title'];
                $incomeType->order = $request->data['order'];
                $incomeType->save();
                $saved = 1;
            }

            return response(
                [
                    'status'=>200,
                    'type'=>'success',
                    'message' => 'Income Type '.($saved ? 'created' : 'updated').' successfully',
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

    public function deleteIncomeType(Request $request)
    {
        try {
            IncomeType::destroy($request['data']['id']);
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
