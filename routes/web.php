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




/* --------------------------------------------- Routes for Patient ------------------------------------------------- */
Route::prefix('/patient')->group( function () {
    Route::get('/{patient}/edit}', [\App\Http\Controllers\PostPatient::class,'edit'])->name('patient.edit');
    Route::put('/{patient}', [\App\Http\Controllers\PostPatient::class,'update'])    ->name('patient.update');
    Route::delete('/{patient}',[\App\Http\Controllers\PostPatient::class,'destroy']) ->name('patient.destroy');
    Route::get('/{patient}',[\App\Http\Controllers\PostPatient::class,'show'])       ->name('patient.show');

});
Route::post('/patients/store', [\App\Http\Controllers\PostPatient::class,'store'])->name('patient.store');
Route::get('/patients/create',[\App\Http\Controllers\PostPatient::class,'create'])->name('patient.create');
Route::get('/patients',[\App\Http\Controllers\PostPatient::class,'index'])->name('patient.index');


/* --------------------------------------------- Routes for Visite ------------------------------------------------- */

Route::prefix('/visit')->group( function () {
    Route::get('/{visit}/edit', [\App\Http\Controllers\PostVisit::class,'edit'])->name('visit.edit');
    Route::put('/{visit}', [\App\Http\Controllers\PostVisit::class,'update'])->name('visit.update');
    Route::delete('/{visit}',[\App\Http\Controllers\PostVisit::class,'destroy'])->name('visit.destroy');
    Route::get('/{visit}',[\App\Http\Controllers\PostVisit::class,'show'])->name('visit.show');

});
Route::get('/visits/create/{patient}', [\App\Http\Controllers\PostVisit::class,'create'])->name('visit.create');
Route::post('/visits/store', [\App\Http\Controllers\PostVisit::class,'store'])->name('visit.store');

/* --------------------------------------------- Routes for Doctor ------------------------------------------------- */

Route::prefix('/doctor')->group( function () {
    Route::get('/{doctor}/edit}', [\App\Http\Controllers\PostMedecin::class,'edit'])->name('doctor.edit');
    Route::put('/{doctor}', [\App\Http\Controllers\PostMedecin::class,'update'])    ->name('doctor.update');
    Route::delete('/{doctor}',[\App\Http\Controllers\PostMedecin::class,'destroy']) ->name('doctor.destroy');
    Route::get('/{doctor}',[\App\Http\Controllers\PostMedecin::class,'show'])       ->name('doctor.show');

});
Route::post('/doctors/store', [\App\Http\Controllers\PostMedecin::class,'store'])->name('doctor.store');
Route::get('/doctors/create',[\App\Http\Controllers\PostMedecin::class,'create'])->name('doctor.create');
Route::get('/doctors',[\App\Http\Controllers\PostMedecin::class,'index'])->name('doctor.index');
/* --------------------------------------------- Routes for Patient ------------------------------------------------- */






Route::any('/listMedic',[\App\Http\Controllers\PostMedicament::class,'index'])->name('showMedications');

Route::match(['get','post'],'/',[\App\Http\Controllers\PostConnection::class,'index'])->name('showConnection');

Route::match(['get','post'],'/cabinet',[\App\Http\Controllers\PostAdministrateur::class,'index'])->name('showCabinet');
Route::put('/cabinet',[\App\Http\Controllers\PostAdministrateur::class,'updateOrCreateCabinet'])->name('updateCabinet');

Route::match(['get','post'],'/erreursimport',[\App\Http\Controllers\PostAdministrateur::class,'goErreursImport'])->name('showImportErrors');
Route::post('/importAll',[\App\Http\Controllers\PostAdministrateur::class, 'importAll'])->name('importAll');
