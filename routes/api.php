<?php
namespace App\Http\Controllers;

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
Route::post('login', [AuthController::class, 'login']);

Route::get('user/tampil', [UserController::class, 'tampil']);
Route::get('user/tampiluser/{id}', [UserController::class, 'tampiluser']);
Route::post('user/tambah', [UserController::class, 'tambah']);
Route::put('user/update/{id}', [UserController::class, 'update']);
Route::get('user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('projek/tampil', [ProjekController::class, 'tampil']);
Route::post('projek/tambah', [ProjekController::class, 'tambah']);
Route::put('projek/update/{id}', [ProjekController::class, 'update']);
Route::get('projek/hapus/{id}', [ProjekController::class, 'hapus']);

Route::get('uploader/tampil/{id}', [UploaderController::class, 'tampil']);
Route::post('uploader/tambah', [UploaderController::class, 'tambah']);
Route::put('uploader/update/{id}', [UploaderController::class, 'update']);
Route::get('uploader/hapus/{id}', [UploaderController::class, 'hapus']);
Route::put('uploader/updateStatus/{id}', [UploaderController::class, 'updateStatus']);
Route::get('uploader/confirmDocument/{id}', [UploaderController::class, 'confirmDocument']);


Route::post('dokumen/tambah/{id}',[DokumenController::class,'tambah']);
Route::post('dokumen/revisi/{id}',[DokumenController::class,'revisi']);
Route::get('dokumen/indexdokumen/{id}',[DokumenController::class,'indexdokumen']);
Route::post('dokumen/confirmdocument/{id}',[DokumenController::class, 'confirmdocument']);
Route::get('dokumen/indexkonfirm/{id}',[DokumenController::class,'indexkonfirm']);
Route::get('dokumen/downloadUploader/{id}',[DokumenController::class,'downloadUploader']);
Route::get('dokumen/downloadRevisi/{id}',[DokumenController::class,'downloadRevisi']);
Route::get('dokumen/downloadRevisiChecker/{id}',[DokumenController::class,'downloadRevisiChecker']);

Route::post('revisi/tambah/{id}', [RevisiController::class,'tambah']);
Route::put('revisi/update/{id}', [RevisiController::class,'update']);
Route::get('revisi/indexdetail/{id}',[RevisiController::class,'indexdetail']);
Route::get('revisi/tampil/{id}', [RevisiController::class, 'tampil']);
Route::get('revisi/hapus/{id}', [RevisiController::class, 'hapus']);
Route::get('revisi/indexchecker/{id}', [RevisiController::class, 'indexchecker']);
Route::get('revisi/indexdrafter/{id}', [RevisiController::class, 'indexdrafter']);
Route::get('revisi/confirmRevisi/{id}', [RevisiController::class, 'confirmRevisi']);

Route::post('revisi/getchecker/{id}', [RevisiController::class, 'getchecker']);

// Route::middleware(['auth:api'])->group(function(){
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('revisi/getchecker/{id}', [RevisiController::class, 'getchecker']);
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
