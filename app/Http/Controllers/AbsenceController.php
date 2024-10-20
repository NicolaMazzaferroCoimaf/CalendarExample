<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:employees,id',
            'absence_date_range' => 'required|string',
            'type' => 'required|in:ferie,malattia,assenza'
        ]);
    
        // Estrai la data di inizio e fine dall'intervallo
        [$startDate, $endDate] = explode(' - ', $validated['absence_date_range']);
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
    
        foreach ($validated['employee_id'] as $employeeId) {
            $currentDate = $startDate->copy();
    
            // Itera e crea un'assenza per ogni giorno dell'intervallo
            while ($currentDate->lessThanOrEqualTo($endDate)) {
                Absence::create([
                    'employee_id' => $employeeId,
                    'absence_date' => $currentDate->format('Y-m-d'),
                    'type' => $validated['type'],
                ]);
                $currentDate->addDay();
            }
        }
    
        return response()->json(['message' => 'Assenza registrata con successo']);
    }
}
