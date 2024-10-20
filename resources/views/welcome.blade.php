<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Assenze e Ore Lavorate</title>
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        
        <!-- Date Range Picker CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
        <!-- Moment.js -->
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    
        <!-- Date Range Picker JS -->
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
        <!-- Bootstrap Multiselect JS -->
        <script src="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"></script>
    </head>
<body>
    <h2>Registrazione Assenza</h2>
    <form action="{{ route('absences.store') }}" method="POST">
        @csrf
        <label for="employee_id">Dipendenti:</label>
        <select name="employee_id[]" id="employee_id" class="multiselect" multiple>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }} {{ $employee->surname }}</option>
            @endforeach
        </select>
        
        <label for="absence_date_range">Periodo di assenza:</label>
        <input type="text" name="absence_date_range" id="absence_date_range">
    
        <label for="type">Tipo di assenza:</label>
        <select name="type" id="type">
            <option value="ferie">Ferie</option>
            <option value="malattia">Malattia</option>
            <option value="assenza">Assenza</option>
        </select>
    
        <button type="submit">Aggiungi assenza</button>
    </form> 
    
    <h2>Registrazione Ore Lavorate</h2>
    <form action="{{ route('work-hours.store') }}" method="POST">
        @csrf
        <label for="employee_id">Dipendenti:</label>
        <select name="employee_id[]" id="employee_id" class="multiselect" multiple>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }} {{ $employee->surname }}</option>
            @endforeach
        </select>
        
        <label for="work_date_range">Periodo di lavoro:</label>
        <input type="text" name="work_date_range" id="work_date_range">
        
        <label for="hours_worked">Ore lavorate al giorno:</label>
        <input type="number" name="hours_worked" id="hours_worked" min="0" max="24" step="0.5">
    
        <button type="submit">Aggiungi ore lavorate</button>
    </form> 
    
    <script type="text/javascript">
        $(document).ready(function() {
            // Inizializza il Date Range Picker
            $('#absence_date_range, #work_date_range').daterangepicker({
                opens: 'center',
                locale: {
                    format: 'YYYY-MM-DD'
                },
                
            });
    
            // Inizializza Bootstrap Multiselect
            $('.multiselect').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Seleziona dipendenti',
                selectAllText: 'Seleziona tutti',
                enableFiltering: true,
                buttonWidth: '100%'
            });
        });
    </script>

</body>
</html>
