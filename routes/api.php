<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\POSController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {


    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'signup']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});


Route::apiResource('/employee', 'App\Http\Controllers\Api\EmployeeController');
Route::apiResource('/supplier','App\Http\Controllers\Api\SupplierController');
Route::apiResource('/category','App\Http\Controllers\Api\CategoryController');
Route::apiResource('/product','App\Http\Controllers\Api\ProductController');
Route::apiResource('/expense','App\Http\Controllers\Api\ExpenseController');
Route::apiResource('/customer','App\Http\Controllers\Api\CustomerController');
Route::post('/salary/paid/{id}',[SalaryController::class,'PaidSalary']);
Route::get('/salary',[SalaryController::class,'AllSalary']);
Route::get('/viewsalary/{id}',[SalaryController::class,'viewsalary']);
Route::get('/editsalary/{id}',[SalaryController::class,'editsalary']);
Route::post('/salary/update/{id}',[SalaryController::class,'updateSalary']);
Route::post('/stock/update/{id}',[ProductController::class,'updateStock']);
Route::post('/category/products/{id}',[POSController::class,'GetProduct']);
Route::get('/addToCart/{id}',[CartController::class,'AddToCart']);
Route::get('/cart/product',[CartController::class,'CartProduct']);
Route::get('/deleteCart/{id}',[CartController::class,'deleteCart']);
Route::get('/increment/{id}',[CartController::class,'increment']);
Route::get('/decrement/{id}',[CartController::class,'decrement']);
Route::get('/discount',[CartController::class,'discount']);
Route::post('/orderdone',[CartController::class,'orderdone']);
Route::get('/allOrders',[OrderController::class,'allOrders']);

Route::get('/orders/{id}',[OrderController::class,'orders']);
Route::get('/ordersdetails/{id}',[OrderController::class,'ordersdetails']);
Route::post('/searchorders',[OrderController::class,'searchorders']);
Route::get('/todaysell',[OrderController::class,'todaysell']);
Route::get('/todayincome',[OrderController::class,'todayincome']);
Route::get('/todaydue',[OrderController::class,'todaydue']);
Route::get('/todayexpense',[OrderController::class,'todayexpense']);
Route::get('/stockout',[OrderController::class,'stockout']);
