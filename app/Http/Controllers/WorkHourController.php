<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WorkHour;
use Illuminate\Http\Request;

class WorkHourController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:employees,id',
            'work_date_range' => 'required|string',
            'hours_worked' => 'required|integer|min:0|max:24'
        ]);
    
        // Estrai la data di inizio e fine dall'intervallo
        [$startDate, $endDate] = explode(' - ', $validated['work_date_range']);
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
    
        foreach ($validated['employee_id'] as $employeeId) {
            $currentDate = $startDate->copy();
    
            // Itera e crea un record di ore lavorate per ogni giorno dell'intervallo
            while ($currentDate->lessThanOrEqualTo($endDate)) {
                WorkHour::create([
                    'employee_id' => $employeeId,
                    'work_date' => $currentDate->format('Y-m-d'),
                    'hours_worked' => $validated['hours_worked'],
                ]);
                $currentDate->addDay();
            }
        }
    
        return response()->json(['message' => 'Ore lavorate registrate con successo']);
    }    
}
