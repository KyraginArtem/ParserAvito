<?php

use App\Http\Controllers\adController;
use App\Http\Controllers\reportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource("/avitoParser", reportController::class);

//create report
Route::post('/avitoParser', [reportController::class, 'createNewReport'])->name('createNewReport');
//destroy report
Route::delete('/avitoParser/{id}', 'reportController@destroy');
//search word
Route::get('avitoParser/{id}/wordSearch', [AdController::class, 'wordSearch'])->name('wordSearch');
//export excel
Route::get('users/export/{id}', [AdController::class, 'export'])->name('export');
