<table>
    <thead>
        <tr>
            <th colspan="{{ 31 + 5 }}" class="month-title">
                {{ ucfirst(\Carbon\Carbon::createFromDate(now()->year, $month, 1)->locale('it')->translatedFormat('F Y')) }}
            </th>
        </tr>
    </thead>
</table>

<table class="monthly-report-table">
    <thead>
        <!-- Riga con i nomi dei giorni della settimana -->
        <tr>
            <th class="header-placeholder"></th> <!-- Cella vuota per allineare i giorni della settimana con i numeri -->
            @for ($day = 1; $day <= date('t', strtotime("$year-$month-01")); $day++)
                @php
                    $date = \Carbon\Carbon::createFromDate($year, $month, $day);
                @endphp
                <th class="header-day">{{ strtolower($date->locale('it')->isoFormat('ddd')) }}</th>
            @endfor
        </tr>
        <!-- Riga con i numeri dei giorni del mese -->
        <tr>
            <th class="header-employee">Nome Dipendente</th>
            @for ($day = 1; $day <= date('t', strtotime("$year-$month-01")); $day++)
                <th class="header-date">{{ $day }}</th>
            @endfor
            <th class="header-total">Totale giorni</th>
            <th class="header-worked">GG Lavorati</th>
            <th class="header-vacation">GG Ferie</th>
            <th class="header-sick">GG Malattia</th>
            <th class="header-permits">GG Assenze</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportData as $data)
            <tr>
                <td class="cell-employee">{{ $data['employee'] }}</td>
                @foreach ($data['days'] as $day)
                    <td class="">{{ $day }}</td>
                @endforeach
                <td class="cell-total">
                    {{
                        collect(range(1, date('t', strtotime("$year-$month-01"))))
                            ->filter(function($day) use ($year, $month) {
                                $weekday = date('N', strtotime("$year-$month-$day"));
                                return $weekday >= 1 && $weekday <= 5; // Da lunedì (1) a venerdì (5)
                            })
                            ->count()
                    }}
                </td>
                <td class="cell-worked">{{ $data['total_days'] }}</td>
                <td class="cell-vacation">{{ $data['absence_counts']['ferie'] }}</td>
                <td class="cell-sick">{{ $data['absence_counts']['malattia'] }}</td>
                <td class="cell-permits">{{ $data['absence_counts']['assenza'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>
    .monthly-report-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    .monthly-report-table thead th {
        padding: 8px;
        text-align: center;
        background-color: #8b0000; /* Colore rosso scuro per intestazioni */
        color: white;
    }

    .header-placeholder {
        background-color: #8b0000;
    }

    .header-employee {
        background-color: #8b0000;
        vertical-align: middle;
    }

    .monthly-report-table tbody td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 8px;
    }

    .header-date, .header-day {
        background-color: #b22222; /* Colore marrone per le date */
        color: white;
        font-weight: bold;
    }

    .cell-employee {
        text-align: left;
        font-weight: bold;
    }

    .header-total, .header-worked, .header-vacation, .header-sick, .header-permits {
        background-color: #8b0000; /* Stessa intestazione rossa */
        color: white;
        font-weight: bold;
        vertical-align: middle;
    }

    .cell-total, .cell-worked, .cell-vacation, .cell-sick, .cell-permits {
        text-align: center;
    }

    .cell-worked {
        background-color: #e0e8b1; /* Colore verde chiaro */
    }

    .cell-vacation {
        background-color: #ffd0c2; /* Colore rosa per ferie */
    }

    .cell-sick {
        background-color: #d4e2fc; /* Colore blu per malattia */
    }

    .cell-permits {
        background-color: #fff5b5; /* Colore giallo chiaro per permessi */
    }

    /* Altri dettagli per bordi e layout della tabella */
    .monthly-report-table thead th,
    .monthly-report-table tbody td {
        border: 1px solid #ccc;
    }

    .month-title {
        font-size: 1.5em;
        font-weight: bold;
        color: #8b0000;
        text-align: center;
        padding: 10px;
    }
</style>
