<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SubkriteriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WPController;
use App\Models\Alternatif;
use App\Models\Subkriteria;
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
Route::group(['middleware'=>['guest']], function(){
    Route::get('login', [UserController::class, 'indexLogin'])->name('login');
    Route::post('login', [UserController::class, 'login']);

});



Route::group(['middleware'=>['auth']], function(){
    Route::get('dash', [UserController::class, 'indexDash']);

    Route::resource('alternatif', AlternatifController::class)->except(['destroy', 'edit', 'show', 'update']);
    Route::get('alternatif/destroy/{id}', [AlternatifController::class, 'destroy']);
    Route::post('alternatif/edit', [AlternatifController::class, 'editalternatif']);
    Route::post('alternatif/store', [AlternatifController::class, 'store']);

    Route::resource('kriteria', KriteriaController::class)->except(['destroy', 'edit', 'store', 'update']);
    Route::get('kriteria/destroy/{id}', [KriteriaController::class, 'destroy']);
    Route::post('kriteria/edit', [KriteriaController::class, 'editkriteria']);
    Route::post('kriteria/store', [KriteriaController::class, 'store']);

    Route::resource('subkriteria', SubkriteriaController::class)->except(['destroy', 'edit', 'store', 'update']);
    Route::post('subkriteria/store', [SubkriteriaController::class, 'store']);
    Route::post('subkriteria/edit', [SubkriteriaController::class, 'edit']);
    Route::get('subkriteria/destroy/{id}', [SubkriteriaController::class, 'destroy']);

    Route::get('wp', [WPController::class, 'index']);
    Route::get('owa', [WPController::class, 'indexOWA']);
    Route::get('hasil', [WPController::class, 'indexHasil']);

    Route::resource('user', UserController::class)->except('destroy', 'edit', 'show', 'update', 'store');
    Route::post('user/store', [UserController::class, 'store']);
    Route::post('user/edit', [UserController::class, 'edit']);
    Route::get('user/destroy/{id}', [UserController::class, 'destroy']);

    Route::resource('penilaian', PenilaianController::class)->except(['destroy', 'edit', 'store', 'update']);
    Route::post('penilaian/edit', [PenilaianController::class, 'editpenilaian']);

    Route::get('logout', [UserController::class, 'logout']);
});

Route::get('/', function () {
    return redirect()->intended('/dash');
});
