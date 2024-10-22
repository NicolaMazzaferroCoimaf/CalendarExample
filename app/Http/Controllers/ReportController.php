<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Absence;
use App\Models\WorkHour;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyAbsenceReportExport;

class ReportController extends Controller
{
    public function generateMonthlyReport(Request $request)
    {
        // Assicurati che il mese sia un valore numerico tra 1 e 12
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        // Verifica che il mese sia tra 1 e 12, altrimenti restituisci un errore
        if ($month < 1 || $month > 12) {
            return back()->withErrors(['month' => 'Il mese deve essere compreso tra 1 e 12.']);
        }

        // Crea una data con Carbon usando solo valori numerici
        $date = Carbon::createFromDate($year, $month, 1);
        $employees = Employee::all();
        $reportData = [];

        foreach ($employees as $employee) {
            $absences = Absence::where('employee_id', $employee->id)
                ->whereYear('absence_date', $year)
                ->whereMonth('absence_date', $month)
                ->get();

            $workHours = WorkHour::where('employee_id', $employee->id)
                ->whereYear('work_date', $year)
                ->whereMonth('work_date', $month)
                ->get();

            $daysInMonth = $date->daysInMonth;
            $days = array_fill(1, $daysInMonth, '');

            foreach ($absences as $absence) {
                $day = Carbon::parse($absence->absence_date)->day;
                $days[$day] = strtoupper(substr($absence->type, 0, 1));
            }

            foreach ($workHours as $workHour) {
                $day = Carbon::parse($workHour->work_date)->day;
                $days[$day] = 'P';
            }

            $reportData[] = [
                'employee' => $employee->name . ' ' . $employee->surname,
                'days' => $days,
                'total_days' => $workHours->count(),
                'total_hours' => $workHours->sum('hours_worked'),
                'absence_counts' => [
                    'ferie' => $absences->where('type', 'ferie')->count(),
                    'malattia' => $absences->where('type', 'malattia')->count(),
                    'permessi' => $absences->where('type', 'permesso')->count(),
                ],
            ];
        }

        if ($request->input('format') === 'excel') {
            return Excel::download(new MonthlyAbsenceReportExport($year, $month), 'report_mensile.xlsx');
        }

        return view('reports.monthly', compact('reportData', 'year', 'month'));
    }

    public function downloadMonthlyReport(Request $request)
    {
        // Assicurati che il mese sia un valore numerico tra 1 e 12
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);
    
        // Verifica che il mese sia tra 1 e 12, altrimenti restituisci un errore
        if ($month < 1 || $month > 12) {
            return back()->withErrors(['month' => 'Il mese deve essere compreso tra 1 e 12.']);
        }
    
        // Crea una data con Carbon usando solo valori numerici
        $date = Carbon::createFromDate($year, $month, 1);
    
        return Excel::download(new MonthlyAbsenceReportExport($year, $month), 'report_mensile_' . $year . '_' . $month . '.xlsx');
    }
    
    
}
