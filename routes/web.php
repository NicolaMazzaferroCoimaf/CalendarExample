<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\WorkHourController;

Route::get('/', [FrontController::class, 'index']);
Route::resource('absences', AbsenceController::class);
Route::resource('work-hours', WorkHourController::class);
Route::get('/calendar-events', [CalendarController::class, 'getEvents']);
Route::get('/calendar', function () {
    return view('calendar');
});
