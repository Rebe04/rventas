<?php

use App\Http\Controllers\PDF\ExportController;
use App\Http\Livewire\Asignar\Asignar;
use App\Http\Livewire\Cashout\CashOut;
use App\Http\Livewire\Category\Categories;
use App\Http\Livewire\Coin\Coins;
use App\Http\Livewire\Dash;
use App\Http\Livewire\Permisos\Permisos;
use App\Http\Livewire\Product\Products;
use App\Http\Livewire\Reports\Reports;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users\Users;
use App\Http\Livewire\Venta\Ventas;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/', Dash::class)->name('home');
    Route::get('categories', Categories::class)->middleware('can:Category_Index')->name('categories');
    Route::get('products', Products::class)->middleware('can:Product_Index')->name('products');
    Route::get('denominations', Coins::class)->middleware('can:Coin_Index')->name('coins');
    Route::get('ventas', Ventas::class)->middleware('can:Ventas_Index')->name('ventas');
    Route::get('roles', Roles::class)->middleware('can:Role_Index')->name('roles');
    Route::get('permisos', Permisos::class)->middleware('can:Permission_Index')->name('permisos');
    Route::get('asignar', Asignar::class)->middleware('can:Asignar_Index')->name('asignar');
    Route::get('usuarios', Users::class)->middleware('can:User_Index')->name('usuarios');
    Route::get('corte-caja', CashOut::class)->middleware('can:Cortes_Index')->name('corte-caja');
    Route::get('reportes', Reports::class)->middleware('can:Reportes_Index')->name('reportes');
    Route::get('report/pdf/{user}/{type}/{f1?}/{f2?}', [ExportController::class, 'reportPDF'])->name('reporte-pdf');
    Route::get('report/excel/{user}/{type}/{f1?}/{f2?}', [ExportController::class, 'reporteExcel'])->name('reporte-excel');
});
