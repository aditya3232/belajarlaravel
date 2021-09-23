<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// email verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    // passing data brand_image langsung dari route tanpa perlu controller
    // biasanya kalau hanya perlu menampilkan view dan passing data (untuk read), maka langung dari route saja
    // $brands = DB::table('brands')->get();
    $brands = Brand::all();
    return view('home',compact('brands'));
});

Route::get('/category/all',[CategoryController::class,'AllCat'])->name('all.category');

Route::post('/category/add',[CategoryController::class,'AddCat'])->name('store.category');

Route::get('/category/edit/{id}',[CategoryController::class,'Edit']);

Route::post('/category/update/{id}',[CategoryController::class,'Update']);

Route::get('/softdelete/category/{id}',[CategoryController::class,'SoftDelete']);

Route::get('/category/restore/{id}',[CategoryController::class,'Restore']);

Route::get('/pdelete/category/{id}',[CategoryController::class,'Pdelete']);

// Brand Route
Route::get('/brand/all',[BrandController::class,'AllBrand'])->name('all.brand');

Route::post('/brand/add',[BrandController::class,'StoreBrand'])->name('store.brand');

Route::get('/brand/edit/{id}',[BrandController::class,'Edit']);

Route::post('/brand/update/{id}',[BrandController::class,'Update']);

Route::get('/brand/delete/{id}',[BrandController::class,'Delete']);

Route::get('/multi/image',[BrandController::class,'Multipic'])->name('multi.image');

Route::post('/multi/add',[BrandController::class,'StoreImg'])->name('store.image');

// Admin route
Route::get('/home/slider',[HomeController::class,'HomeSlider'])->name('home.slider');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    return view('admin.index');
})->name('dashboard');

// route user logout
Route::get('/user/logout',[BrandController::class,'Logout'])->name('user.logout');