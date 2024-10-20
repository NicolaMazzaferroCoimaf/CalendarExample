<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\WorkHour;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getEvents(Request $request)
    {
        $absences = Absence::all()->map(function ($absence) {
            return [
                'title' => $absence->type . ' - ' . $absence->employee->name,
                'start' => $absence->absence_date,
                'color' => '#f54242', // Rosso per indicare le assenze
            ];
        });

        $workHours = WorkHour::all()->map(function ($workHour) {
            return [
                'title' => 'Presenza - ' . $workHour->employee->name . ' (' . $workHour->hours_worked . ' ore)',
                'start' => $workHour->work_date,
                'color' => '#42f54b', // Verde per indicare i giorni lavorati
            ];
        });

        return response()->json(array_merge($absences->toArray(), $workHours->toArray()));
    }
}
