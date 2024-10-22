<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Absence;
use App\Models\WorkHour;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyAbsenceReportExport implements FromView, WithStyles
{
    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = (int) $year;
        $this->month = (int) $month;
    }

    public function view(): View
    {
        // Recupera i dipendenti e genera il report per Excel
        $employees = Employee::all();
        $reportData = [];

        foreach ($employees as $employee) {
            $absences = Absence::where('employee_id', $employee->id)
                ->whereYear('absence_date', $this->year)
                ->whereMonth('absence_date', $this->month)
                ->get();

            $workHours = WorkHour::where('employee_id', $employee->id)
                ->whereYear('work_date', $this->year)
                ->whereMonth('work_date', $this->month)
                ->get();

            $daysInMonth = date('t', strtotime("$this->year-$this->month-01"));
            $days = array_fill(1, $daysInMonth, '');

            foreach ($absences as $absence) {
                $day = date('j', strtotime($absence->absence_date));
                $days[$day] = strtoupper(substr($absence->type, 0, 1));
            }

            foreach ($workHours as $workHour) {
                $day = date('j', strtotime($workHour->work_date));
                $days[$day] = $workHour->hours_worked; // Mostra le ore lavorate al posto della "P"
            }

            $workDaysCount = collect($workHours)->groupBy(function ($workHour) {
                return date('Y-m-d', strtotime($workHour->work_date));
            })->count();

            $reportData[] = [
                'employee' => $employee->name . ' ' . $employee->surname,
                'days' => $days,
                'total_days' => $workDaysCount,
                'total_hours' => $workHours->sum('hours_worked'),
                'absence_counts' => [
                    'ferie' => $absences->where('type', 'ferie')->count(),
                    'malattia' => $absences->where('type', 'malattia')->count(),
                    'assenza' => $absences->where('type', 'assenza')->count(),
                ],
            ];
        }

        return view('reports.monthly_excel', [
            'reportData' => $reportData,
            'year' => $this->year,
            'month' => date('m', strtotime("$this->year-$this->month-01")),
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Determina la colonna massima (AK) da formattare
        $highestColumn = 'AK';
        
        // Applica stili alle intestazioni (da A1 a AK1)
        $sheet->getStyle("A3:{$highestColumn}3")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '8B0000'],
            ],
        ]);
    
        // Stili per le celle specifiche, partendo dalla riga 2
        $highestRow = $sheet->getHighestRow();
    
        // Itera su tutte le righe (a partire dalla seconda) e su tutte le colonne fino a 'AK'
        for ($row = 2; $row <= $highestRow; $row++) {
            for ($col = 'A'; $col !== $highestColumn; $col++) {
                // Recupera il valore della cella corrente
                $cellValue = $sheet->getCell("{$col}{$row}")->getValue();
    
                if ($cellValue == 'F') {
                    $sheet->getStyle("{$col}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => 'solid',
                            'startColor' => ['rgb' => 'FFD0C2'], // Colore rosa per Ferie
                        ],
                    ]);
                } elseif ($cellValue == 'M') {
                    $sheet->getStyle("{$col}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => 'solid',
                            'startColor' => ['rgb' => 'D4E2FC'], // Colore blu per Malattia
                        ],
                    ]);
                } elseif ($cellValue == 'A') {
                    $sheet->getStyle("{$col}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => 'solid',
                            'startColor' => ['rgb' => 'FFF5B5'], // Colore giallo per Altri tipi (es: aspettativa)
                        ],
                    ]);
                }
            }
        }
    
        // Auto-adatta la larghezza di tutte le colonne fino ad 'AK'
        foreach (range('A', $highestColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    
        return [
            // Applica lo stile alle intestazioni di tutte le colonne
            'A' => ['font' => ['bold' => true]],
            "A:{$highestColumn}" => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}
