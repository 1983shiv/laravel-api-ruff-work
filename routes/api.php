<?php


use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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


// Route::get('/product', function(){
//     return "Hello Shiv";
// })


// use App\Models\Product   model 

// Route::get('/product', function(){
//     return Product::all();
// })

// Route:post('/product', function(){
//     return Product::create([
//         'name' => 'Product 2',
//         'slug' => 'product-2',
//         'description' => 'for product 2',
//         'quantity' => 4,
//         'price' => 123.22
//     ]);
// })

Route::get('/', function(){
    return response()->json([
        'message' => 'This api is only for authenticated users, if you are a authenticated user, than you must be receive a valid request api url and necessary credentials, Thanking you for visiting us.',
    ], 200);
});

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
