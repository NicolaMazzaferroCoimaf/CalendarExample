<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WorkHour;
use Illuminate\Http\Request;

class WorkHourController extends Controller
{
    public function store(Request $request)
    {
        // Validazione della richiesta
        $validated = $request->validate([
            'employee_ids' => 'required|string', // Gli ID dei dipendenti sono una stringa separata da virgole
            'work_date' => 'required|date',      // Data di lavoro deve essere una data valida
            'hours_worked' => 'required|numeric|min:0|max:24' // Le ore lavorate devono essere tra 0 e 24
        ]);

        // Estrai gli ID dei dipendenti dalla stringa e crea un array
        $employeeIds = explode(',', $validated['employee_ids']);

        // Itera su ogni dipendente selezionato e crea o aggiorna un record separato per ciascuno
        foreach ($employeeIds as $employeeId) {
            WorkHour::updateOrCreate(
                [
                    'employee_id' => $employeeId,
                    'work_date' => Carbon::parse($validated['work_date'])->format('Y-m-d'),
                ],
                [
                    'hours_worked' => $validated['hours_worked'],
                ]
            );
        }

        // Redirect alla vista 'showByDate' per la data specificata
        return redirect()->route('absences.showByDate', ['date' => $validated['work_date']])
                         ->with('message', 'Ore lavorate registrate con successo');
    }
}
