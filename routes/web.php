<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoriesComponent;
use App\Http\Livewire\ProductsComponent;
use App\Http\Livewire\DenominationsComponent;
use App\Http\Livewire\PosComponent;
use App\Http\Livewire\RolesComponent;
use App\Http\Livewire\PermisosComponent;
use App\Http\Livewire\AsignarComponent;
use App\Http\Livewire\UsersComponent;
use App\Http\Livewire\CashoutComponent;
use App\Http\Livewire\ReportsComponent;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
/*Route::get('login/login', 'Auth\LoginController@index')->name('login');
Route::post('login/login', 'Auth\LoginController@login')->name('login');
Route::get('login/logout', 'Auth\LoginController@logout')->name('logout');*/
//Route::post('/login', [LoginController::class, 'login']);
//Route:put('/login', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){

    Route::middleware(['role:Administrador'])->group(function(){
        Route::get('categories', CategoriesComponent::class);
        Route::get('products', ProductsComponent::class);
        Route::get('denominations', DenominationsComponent::class);
        Route::get('roles', RolesComponent::class);
        Route::get('permisos', PermisosComponent::class);
        Route::get('asignar', AsignarComponent::class);
        Route::get('users', UsersComponent::class);
    });

    Route::middleware(['role:Administrador|Supervisor'])->group(function(){
        Route::get('cashout', CashoutComponent::class);
        Route::get('reports', ReportsComponent::class);
    });
    
    Route::middleware(['role:Administrador|Supervisor|Cajero'])->group(function(){
        Route::get('pos', PosComponent::class);
    });
    

    Route::get('report/pdf/{userid}/{type}/{dateFrom?}/{dateTo?}', [ExportController::class, 'reportPDF']);
    Route::get('report/excel/{userid}/{type}/{dateFrom?}/{dateTo?}', [ExportController::class, 'reportExcel']);
});