<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\IncomeCategory;
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
    public function saveIncomeData(Request $request)
    {
        try {
            $items = $request->items;
            foreach($items as $item){
                // update
                if (isset($item['id'])) {
                    Income::find($item['id'])->update($item);

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
