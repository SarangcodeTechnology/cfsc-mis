<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\CfData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function CFData(Request $request){

        if($request->search){
            $search = $request->search;
            $cfData = CfData::with(['district','province','localLevel','physiography','subdivision','vegetationType','forestType','forestCondition'])->get();
            $cfData =  CollectionHelper::paginate($cfData->filter(function ($item) use ($search) {
                return false !== stripos($item, $search);
            })->values(),$request->totalItems);
        }
        else{
            $cfData= CfData::with(['district','province','localLevel','physiography','subdivision','vegetationType','forestType','forestCondition'])->paginate($request->totalItems);
        }

        return response([
            'status' => 200,
            'type' => 'success',
            'message' => 'Data loaded successfully.',
            'data' => [
                'cfData' => $cfData,
                'totalCfData' => $cfData['total'],
            ]
        ]);

    }

    public function search(Request $request){
        $cfData = CfData::with(['district','province','localLevel','physiography','subdivision','vegetationType','forestType','forestCondition'])->get();


        $paginatedData =  CollectionHelper::paginate($cfData->where('district.name','Makwanpur'),$request->totalItems);
        return response([
            'status' => 200,
            'type' => 'success',
            'message' => 'Data loaded successfully.',
            'data' => [
                'cfData' => $paginatedData,
                'totalCfData' => $paginatedData['total'],
            ]
        ]);

    }
}
