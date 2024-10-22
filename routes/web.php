<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\WorkHourController;


Route::get('/', [CalendarController::class, 'index']);
Route::get('/absences/{date}', [CalendarController::class, 'showByDate'])->name('absences.showByDate');
Route::get('/absences/create/{date}', [CalendarController::class, 'create'])->name('absences.create');
Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
Route::post('/work-hours', [WorkHourController::class, 'store'])->name('work-hours.store');

Route::get('/reports/monthly', [ReportController::class, 'generateMonthlyReport'])->name('reports.monthly');
Route::get('/reports/monthly/download', [ReportController::class, 'downloadMonthlyReport'])->name('reports.monthly.download');
