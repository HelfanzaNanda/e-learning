<?php

use App\Http\Controllers\Quiz10Controller;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;


Route::get('/', [QuizController::class, 'index'])->name('quiz');
Route::get('/get-data/{id?}/{number?}', [QuizController::class, 'getData']);
Route::get('/get-data-sidebar/{id}/{number}', [QuizController::class, 'getDataBySidebar']);
Route::get('/mark/{id}', [QuizController::class, 'mark']);
Route::post('/submit', [QuizController::class, 'store']);


Route::get('/10', [Quiz10Controller::class, 'index'])->name('quiz.10');
Route::get('/10/get-data/{id?}/{number?}/{prev?}', [Quiz10Controller::class, 'getData']);
Route::get('/10/get-data-sidebar/{id?}/{number?}', [Quiz10Controller::class, 'getDataBySidebar']);
Route::get('/10/mark/{id}', [Quiz10Controller::class, 'mark']);
Route::post('/10/submit', [Quiz10Controller::class, 'store']);
