<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kharcha;
use Illuminate\Http\Request;

class KharchaController extends Controller
{
    public function index()
    {
        try {
            $kharcha = Kharcha::orderBy('created_at', 'desc')->get();
            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Kharcha loaded successfully',
                    'data' => compact('kharcha')
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

    public function saveKharcha(Request $request)
    {
        try {
            // update
            if (isset($request->data['id'])) {
                $kharcha = Kharcha::find($request->data['id']);
                $kharcha->title = $request->data['title'];
                $kharcha->order = $request->data['order'];
                $kharcha->update();
                $saved = 0;
            } // create
            else {
                $kharcha = new Kharcha();
                $kharcha->title = $request->data['title'];
                $kharcha->order = $request->data['order'];
                $kharcha->save();
                $saved = 1;
            }

            return response(
                [
                    'status' => 200,
                    'type' => 'success',
                    'message' => 'Kharcha  ' . ($saved ? 'created' : 'updated') . ' successfully',
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

    public function deleteKharcha(Request $request)
    {
        try {
            Kharcha::destroy($request['data']['id']);
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
