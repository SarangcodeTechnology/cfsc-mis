<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\CfData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function CFData(Request $request){
        $cfData= CfData::paginate($request->totalItems);
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
}
