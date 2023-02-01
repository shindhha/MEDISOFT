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



Route::prefix('/editDoctor')->group( function () {
    Route::match(['get','post'],'/{id?}', [\App\Http\Controllers\PostAdministrateur::class,'goEditDoctor'])->name('editDoctor');
    Route::put('/{id}', [\App\Http\Controllers\PostAdministrateur::class,'updateDoctor'])->name('updateDoctor');
    Route::put('/', [\App\Http\Controllers\PostAdministrateur::class,'addDoctor'])->name('addDoctor');
});
Route::post('/deleteDoctor',[\App\Http\Controllers\PostAdministrateur::class,'deleteDoctor'])->name('deleteDoctor');
Route::any('/ficheMedecin/{id}',[\App\Http\Controllers\PostAdministrateur::class,'showDoctor'])->name('showDoctor');
Route::match(['get','post'],'/listMedecin',[\App\Http\Controllers\PostAdministrateur::class,'goListMedecins'])->name('showDoctors');


Route::prefix('/editPatient')->group( function () {
    Route::match(['get','post'],'/{id?}', [\App\Http\Controllers\PostMedecin::class,'goEditPatient'])->name('editPatient');
    Route::put('/{id}', [\App\Http\Controllers\PostMedecin::class,'updatePatient'])->name('updatePatient');
    Route::put('/', [\App\Http\Controllers\PostMedecin::class,'addPatient'])->name('addPatient');
});
Route::post('/deletePatient',[\App\Http\Controllers\PostMedecin::class,'deletePatient'])->name('deletePatient');
Route::any('/PatientSheet/{id}',[\App\Http\Controllers\PostMedecin::class,'showPatient'])->name('showPatient');
Route::match(['get','post'],'/listPatient',[\App\Http\Controllers\PostMedecin::class,'index'])->name('showPatients');



Route::prefix('editVisite')->group( function () {
        Route::match(['get','post'],'/{id?}', [\App\Http\Controllers\PostMedecin::class,'goEditVisit'])->name('editVisit');
        Route::put('/{id}', [\App\Http\Controllers\PostMedecin::class,'updateVisit'])->name('updateVisit');
        Route::put('/', [\App\Http\Controllers\PostMedecin::class,'addVisit'])->name('addVisit');
});
Route::post('/deleteVisite',[\App\Http\Controllers\PostMedecin::class,'deleteVisit'])->name('deleteVisit');
Route::any('/VisiteSheet/{id}',[\App\Http\Controllers\PostMedecin::class,'showVisit'])->name('showVisit');


Route::any('/listMedic',[\App\Http\Controllers\PostMedicament::class,'index'])->name('showMedications');

Route::match(['get','post'],'/',[\App\Http\Controllers\PostConnection::class,'index'])->name('showConnection');

Route::match(['get','post'],'/cabinet',[\App\Http\Controllers\PostAdministrateur::class,'index'])->name('showCabinet');
Route::put('/cabinet',[\App\Http\Controllers\PostAdministrateur::class,'updateOrCreateCabinet'])->name('updateCabinet');

Route::match(['get','post'],'/erreursimport',[\App\Http\Controllers\PostAdministrateur::class,'goErreursImport'])->name('showImportErrors');
Route::post('/importAll',[\App\Http\Controllers\PostAdministrateur::class, 'importAll'])->name('importAll');
