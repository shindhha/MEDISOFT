<?php

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


Route::match(['get','post'],'/',[\App\Http\Controllers\PostConnection::class,'index']);

Route::match(['get','post'],'/cabinet',[\App\Http\Controllers\PostAdministrateur::class,'index'])->name('administrateur');
Route::match(['get','post'],'/d',[\App\Http\Controllers\PostMedecin::class,'index'])->name('medecin');
Route::put('/cabinet',[\App\Http\Controllers\PostAdministrateur::class,'updateOrCreateCabinet']);
Route::match(['get','post'],'/listMedecin',[\App\Http\Controllers\PostAdministrateur::class,'goListMedecins'])->name('doctorList');
Route::match(['get','post'],'/erreursimport',[\App\Http\Controllers\PostAdministrateur::class,'goErreursImport']);
Route::prefix('/editDoctor')->group( function () {
    Route::match(['get','post'],'', [\App\Http\Controllers\PostAdministrateur::class,'goEditDoctor'])->name('add');
    Route::match(['get','post'],'/{id}', [\App\Http\Controllers\PostAdministrateur::class,'goEditDoctor'])->name('update');
    Route::put('/{id}', [\App\Http\Controllers\PostAdministrateur::class,'updateMedecin']);
    Route::put('/', [\App\Http\Controllers\PostAdministrateur::class,'addMedecin']);
}     
);

Route::prefix('/editPatient')->group( function () {
    Route::match(['get','post'],'', [\App\Http\Controllers\PostMedecin::class,'goEditPatient'])->name('addPatient');
    Route::match(['get','post'],'/{id}', [\App\Http\Controllers\PostMedecin::class,'goEditPatient'])->name('updatePatient');
    Route::put('/{id}', [\App\Http\Controllers\PostMedecin::class,'updatePatient']);
    Route::put('/', [\App\Http\Controllers\PostMedecin::class,'addPatient']);
}     
);
Route::post('/deleteDoctor',[\App\Http\Controllers\PostAdministrateur::class,'deleteMedecin'])->name('deleteDoctor');
Route::any('/ficheMedecin/{id}',[\App\Http\Controllers\PostAdministrateur::class,'goDoctorSheet'])->name('show');