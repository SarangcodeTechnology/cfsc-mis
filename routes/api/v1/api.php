<?php

use App\Http\Controllers\api\v1\AarthikBarsaController;
use App\Http\Controllers\api\v1\DataController;
use App\Http\Controllers\api\v1\IncomeCategoryController;
use App\Http\Controllers\api\v1\IncomeController;
use App\Http\Controllers\api\v1\IncomeTypeController;
use App\Http\Controllers\api\v1\DeleteController;
use App\Http\Controllers\api\v1\KharchaCategoryController;
use App\Http\Controllers\api\v1\KharchaController;
use App\Http\Controllers\api\v1\KharchaTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaaryalayaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);
Route::middleware('auth:api')->post('logout', [AuthController::class,'logout']);
Route::middleware('auth:api')->get('cf-data', [DataController::class,'CFData']);
Route::middleware('auth:api')->post('save-cf-data',[DataController::class,'saveCfData']);
Route::middleware('auth:api')->post('delete-cf-data',[DataController::class,'deleteCfData']);
Route::middleware('auth:api')->post('fug-approval-date',[DataController::class,'saveFugApprovalDate']);




Route::middleware('auth:api')->get('load-resources',[DataController::class,'loadResources']);
Route::middleware('auth:api')->get('users', [UserController::class,'index']);
Route::middleware('auth:api')->post('permissions-data-for-user', [UserController::class,'permissionsDataForUser']);
Route::middleware('auth:api')->post('save-user-data',[UserController::class,'saveUserData']);

// roles
Route::middleware('auth:api')->get('roles', [RoleController::class,'index']);
Route::middleware('auth:api')->post('save-role-data',[RoleController::class,'saveRoleData']);


// permissions
Route::middleware('auth:api')->get('permissions', [PermissionController::class,'index']);
Route::middleware('auth:api')->post('save-permission-data',[PermissionController::class,'savePermissionData']);

// aarthik-barsa
Route::middleware('auth:api')->get('aarthik-barsa', [AarthikBarsaController::class,'index']);
Route::middleware('auth:api')->post('save-aarthik-barsa',[AarthikBarsaController::class,'saveAarthikBarsa']);
Route::middleware('auth:api')->post('delete-aarthik-barsa',[AarthikBarsaController::class,'deleteAarthikBarsa']);

// kharcha-category
Route::middleware('auth:api')->get('kharcha-categories', [KharchaCategoryController::class,'index']);
Route::middleware('auth:api')->post('save-kharcha-categories',[KharchaCategoryController::class,'saveKharchaCategory']);
Route::middleware('auth:api')->post('delete-kharcha-categories',[KharchaCategoryController::class,'deleteKharchaCategory']);

// kharcha-types
Route::middleware('auth:api')->get('kharcha-types', [KharchaTypeController::class,'index']);
Route::middleware('auth:api')->post('save-kharcha-types',[KharchaTypeController::class,'saveKharchaType']);
Route::middleware('auth:api')->post('delete-kharcha-types',[KharchaTypeController::class,'deleteKharchaType']);

// income-category
Route::middleware('auth:api')->get('income-categories', [IncomeCategoryController::class,'index']);
Route::middleware('auth:api')->post('save-income-categories',[IncomeCategoryController::class,'saveIncomeCategory']);
Route::middleware('auth:api')->post('delete-income-categories',[IncomeCategoryController::class,'deleteIncomeCategory']);

// income-types
Route::middleware('auth:api')->get('income-types', [IncomeTypeController::class,'index']);
Route::middleware('auth:api')->post('save-income-types',[IncomeTypeController::class,'saveIncomeType']);
Route::middleware('auth:api')->post('delete-income-types',[IncomeTypeController::class,'deleteIncomeType']);

// income
Route::middleware('auth:api')->get('income', [IncomeController::class,'index']);
Route::middleware('auth:api')->post('save-income',[IncomeController::class,'saveIncome']);
Route::middleware('auth:api')->post('delete-income',[IncomeController::class,'deleteIncome']);

// kharcha-types
Route::middleware('auth:api')->get('kharcha', [KharchaController::class,'index']);
Route::middleware('auth:api')->post('save-kharcha',[KharchaController::class,'saveKharcha']);
Route::middleware('auth:api')->post('delete-kharcha',[KharchaController::class,'deleteKharcha']);



//delete
Route::middleware('auth:api')->post('delete',[DeleteController::class,'delete']);


// kaaryalaya
Route::middleware('auth:api')->get('kaaryalaya', [KaaryalayaController::class,'index']);
Route::middleware('auth:api')->post('save-kaaryalaya-data',[KaaryalayaController::class,'saveKaaryalayaData']);

Route::middleware('auth:api')->post('kharcha-data',[KharchaController::class,'getKharchaData']);

// save kharcha data
Route::middleware('auth:api')->post('save-kharcha-data',[KharchaController::class,'saveKharchaData']);


Route::middleware('auth:api')->post('income-data',[IncomeController::class,'getIncomeData']);
Route::middleware('auth:api')->post('save-income-data',[IncomeController::class,'saveIncomeData']);



