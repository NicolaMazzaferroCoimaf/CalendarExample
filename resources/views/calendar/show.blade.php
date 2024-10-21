@extends('layouts.app')


@section('content')
<div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <p class="p-2 bg-primary text-white text-center rounded rounded-pill fw-bold" style="width: 15%"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week me-1 mb-1 fw-bold" viewBox="0 0 16 16">
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
          </svg> {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</p>
    
        @if ($absences->isEmpty() && $workHours->isEmpty())
            <p>Non ci sono dati disponibili per questa data.</p>
        @else
    
        <div class="container mt-5">
            <div class="row">
                <div class="col-6">
                    <h3>Presenze</h3>
                    @if ($workHours->isEmpty())
                        <p>Nessuna presenza registrata.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr class="align-middle">
                                    <th>Dipendente</th>
                                    <th class="text-center">Ore Lavorate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workHours as $workHour)
                                    <tr>
                                        <td>{{ $workHour->employee->name }} {{ $workHour->employee->surname }}</td>
                                        <td class="text-center">{{ $workHour->hours_worked }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="col-6">
                    <h3>Assenze</h3>
                    @if ($absences->isEmpty())
                        <p>Nessuna assenza registrata.</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Dipendente</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absences as $absence)
                                    <tr>
                                        <td>{{ $absence->employee->name }} {{ $absence->employee->surname }}</td>
                                        <td>{{ $absence->type }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        @endif
    
        <a href="{{ route('absences.create', ['date' => $date]) }}" class="btn btn-primary w-100 mt-5">Modifica Presenze</a>
    </div>

@endsection
