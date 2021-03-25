<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\CfData;
use App\Models\Province;
use Exception;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function CFData(Request $request)
    {
        try {
            if ($request->search) {
                $search = $request->search;
                $cfData = CfData::with(['district', 'province', 'localLevel', 'physiography', 'subdivision', 'vegetationType', 'forestType', 'forestCondition'])->get();
                $cfData = CollectionHelper::paginate($cfData->filter(function ($item) use ($search) {
                    return false !== stripos($item, $search);
                })->values(), $request->totalItems);
            } else {
                $cfData = CfData::with(['district', 'province', 'localLevel', 'physiography', 'subdivision', 'vegetationType', 'forestType', 'forestCondition'])->paginate($request->totalItems);
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
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function search(Request $request)
    {
        try {
            $cfData = CfData::with(['district', 'province', 'localLevel', 'physiography', 'subdivision', 'vegetationType', 'forestType', 'forestCondition'])->get();
            $paginatedData = CollectionHelper::paginate($cfData->where('district.name', 'Makwanpur'), $request->totalItems);
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data loaded successfully.',
                'data' => [
                    'cfData' => $paginatedData,
                    'totalCfData' => $paginatedData['total'],
                ]
            ]);
        } catch (Exception $e) {
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function loadResources(Request $request)
    {
        try {
            $provinces = Province::with('districts.localLevels')->get();
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Resources loaded successfully',
                'data' => [
                    'provinces' => $provinces,
                ]
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
