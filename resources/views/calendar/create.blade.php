@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Colonna con la lista dei dipendenti -->
            <div class="col-2 bg-light vh-100 overflow-auto">
                <h4 class="pt-3">Lista Dipendenti</h4>
                
                <!-- Lista di checkbox per i dipendenti -->
                <div id="employee_checklist" class="form-group mt-3">
                    @foreach ($employees as $employee)
                        <div class="form-check">
                            <input type="checkbox" name="employee_id[]" value="{{ $employee->id }}" id="checkbox_employee_{{ $employee->id }}" class="form-check-input">
                            <label class="form-check-label" for="checkbox_employee_{{ $employee->id }}">
                                {{ $employee->name }} {{ $employee->surname }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div> 

            <!-- Colonna principale con i form -->
            <div class="col-10">
                <div class="container">
                    <p class="ms-5 p-2 bg-primary text-white text-center rounded rounded-pill fw-bold" style="width: 15%">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week me-1 mb-1 fw-bold" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                        </svg> {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                    </p>

                    <div class="row">
                        <!-- Form per le Assenze -->
                        <div class="col-md-6">
                            <div class="absence-section mt-3 p-3 bg-light border rounded">
                                <h4>Aggiungi Assenza</h4>
                                <form action="{{ route('absences.store') }}" method="POST" id="absence_form">
                                    @csrf
                                    <input type="hidden" name="absence_date_range" value="{{ $date }} - {{ $date }}">
                                    <input type="hidden" name="employee_ids" id="absence_employee_ids">

                                    <label for="type" class="mt-3">Tipo di assenza:</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="ferie">Ferie</option>
                                        <option value="malattia">Malattia</option>
                                        <option value="assenza">Assenza</option>
                                    </select>

                                    <button type="submit" class="btn btn-danger mt-3">Aggiungi Assenza</button>
                                </form>
                            </div>
                        </div>

                        <!-- Form per le Presenze -->
                        <div class="col-md-6">
                            <div class="workhour-section mt-3 p-3 bg-light border rounded">
                                <h4>Aggiungi Presenza</h4>
                                <form action="{{ route('work-hours.store') }}" method="POST" id="workhour_form">
                                    @csrf
                                    <input type="hidden" name="work_date" value="{{ $date }}">
                                    <input type="hidden" name="employee_ids" id="work_employee_ids">

                                    <label for="hours_worked" class="mt-3">Ore lavorate:</label>
                                    <input type="number" name="hours_worked" id="hours_worked" min="0" max="24" step="0.5" class="form-control">

                                    <button type="submit" class="btn btn-success mt-3">Aggiungi Presenza</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gestisce l'evento di invio del form per le assenze
        document.getElementById('absence_form').addEventListener('submit', function (event) {
            const selectedEmployees = Array.from(document.querySelectorAll('#employee_checklist .form-check-input:checked')).map(checkbox => checkbox.value);
            console.log('Dipendenti selezionati per assenza:', selectedEmployees); // Log per verifica
            if (selectedEmployees.length === 0) {
                event.preventDefault();
                alert('Devi selezionare almeno un dipendente per aggiungere un\'assenza.');
            } else {
                document.getElementById('absence_employee_ids').value = selectedEmployees.join(',');
            }
        });

        // Gestisce l'evento di invio del form per le presenze
        document.getElementById('workhour_form').addEventListener('submit', function (event) {
            const selectedEmployees = Array.from(document.querySelectorAll('#employee_checklist .form-check-input:checked')).map(checkbox => checkbox.value);
            console.log('Dipendenti selezionati per presenze:', selectedEmployees); // Log per verifica
            if (selectedEmployees.length === 0) {
                event.preventDefault();
                alert('Devi selezionare almeno un dipendente per aggiungere una presenza.');
            } else {
                document.getElementById('work_employee_ids').value = selectedEmployees.join(',');
            }
        });
    });
</script>
