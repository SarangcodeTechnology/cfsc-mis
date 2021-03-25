<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\CfData;
use App\Models\Province;
use App\Models\LocalLevel;
use App\Models\District;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        return $provinces = Province::with('districts.localLevels')->get();
    }
}
