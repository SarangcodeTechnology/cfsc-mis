<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(Request $request){
        try{
            if ($request->search) {
                $search = $request->search;
                $items = Division::orderBy('created_at','desc')->get();
                $items = CollectionHelper::paginate($items->filter(function ($item) use ($search) {
                    return false !== stripos($item, $search);
                })->values(), $request->totalItems);
            } else {
                $items = Division::orderBy('created_at','desc')->paginate($request->totalItems);
            }
            return response([
                'status' => 200,
                'type' => 'success',
                'message' => 'Data loaded successfully.',
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
            if($type=='created') Division::create($request->items);
            //update
            else Division::find($request->items['id'])->update($request->items);

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
