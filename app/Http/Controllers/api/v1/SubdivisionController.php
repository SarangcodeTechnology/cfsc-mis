<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\SubDivision;
use Illuminate\Http\Request;

class SubdivisionController extends Controller
{
    public function index(Request $request){
        try{
            if ($request->search) {
                $search = $request->search;
                $items = SubDivision::all();
                $items = CollectionHelper::paginate($items->filter(function ($item) use ($search) {
                    return false !== stripos($item, $search);
                })->values(), $request->totalItems);
            } else {
                $items = SubDivision::paginate($request->totalItems);
            }
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data saved successfully.',
                'data' => compact('items')
            ]);
        }
        catch(Exception $e){
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function createOrUpdate(Request $request){
        try{
            $type = $request->items['id'] ? 'updated' : 'created';
            //create
            if($type=='created') SubDivision::create($request->items);
            //update
            else SubDivision::find($request->items['id'])->update($request->items);

            return response([
                'status' => 200,
                'type' => 'success',
                'message' => "Data {$type} successfully"
            ]);
        }
        catch(Exception $e){
            return response([
                'status' => $e->getCode(),
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
