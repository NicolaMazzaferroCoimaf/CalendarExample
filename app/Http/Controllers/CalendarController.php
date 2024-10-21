<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employee;
use App\Models\WorkHour;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function showByDate($date)
    {
        $absences = Absence::where('absence_date', $date)->get();
        $workHours = WorkHour::where('work_date', $date)->get();
        return view('calendar.show', compact('absences', 'workHours', 'date'));
    }

    public function create($date)
    {
        $employees = Employee::all();
        return view('calendar.create', compact('employees', 'date'));
    }
}
