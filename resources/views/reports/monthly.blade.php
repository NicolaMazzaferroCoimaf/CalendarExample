@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Report Mensili</h2>

        @php
            // Array di nomi dei mesi statici
            $monthNames = [
                1 => 'Gennaio', 
                2 => 'Febbraio', 
                3 => 'Marzo', 
                4 => 'Aprile', 
                5 => 'Maggio', 
                6 => 'Giugno',
                7 => 'Luglio', 
                8 => 'Agosto', 
                9 => 'Settembre', 
                10 => 'Ottobre', 
                11 => 'Novembre', 
                12 => 'Dicembre'
            ];
        @endphp

        <div class="row mt-4">
            @for ($month = 1; $month <= 12; $month++)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $monthNames[$month] }}</h5>
                            <p class="card-text">Scarica il report per il mese di {{ $monthNames[$month] }}.</p>

                            <!-- Bottone per scaricare il report in PDF -->
                            <a href="{{ route('reports.monthly', ['year' => now()->year, 'month' => $month, 'format' => 'pdf']) }}"
                               class="btn btn-primary">
                                Scarica PDF
                            </a>

                            <!-- Bottone per scaricare il report in Excel -->
                            <a href="{{ route('reports.monthly.download', ['year' => now()->year, 'month' => intval($month)]) }}" class="btn btn-primary">
                                Scarica Report per {{ \Carbon\Carbon::createFromDate(now()->year, $month, 1)->format('F') }}
                            </a>
                            
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection
