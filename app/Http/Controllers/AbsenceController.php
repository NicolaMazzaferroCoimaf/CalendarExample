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
            'employee_ids' => 'required|string', // Gli ID dei dipendenti sono una stringa separata da virgole
            'absence_date_range' => 'required|string',
            'type' => 'required|in:ferie,malattia,assenza'
        ]);

        // Estrai la data di inizio e la data di fine dall'intervallo
        [$startDate, $endDate] = explode(' - ', $validated['absence_date_range']);
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        // Estrai gli ID dei dipendenti dalla stringa e crea un array
        $employeeIds = explode(',', $validated['employee_ids']);

        foreach ($employeeIds as $employeeId) {
            $currentDate = $startDate->copy();

            // Itera e crea o aggiorna un'assenza per ogni giorno dell'intervallo
            while ($currentDate->lessThanOrEqualTo($endDate)) {
                Absence::updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'absence_date' => $currentDate->format('Y-m-d'),
                    ],
                    [
                        'type' => $validated['type'],
                    ]
                );
                $currentDate->addDay();
            }
        }

        return redirect()->route('absences.showByDate', ['date' => $startDate->format('Y-m-d')])
                         ->with('message', 'Assenza registrata con successo');
    }

    public function showByDate($date)
    {
        $absences = Absence::where('absence_date', $date)->get();
        $workHours = WorkHour::where('work_date', $date)->get();
        return view('absences.show', compact('absences', 'workHours', 'date'));
    }

    public function show($id)
    {
        $absence = Absence::findOrFail($id);
        return view('absences.show', compact('absence'));
    }
}
