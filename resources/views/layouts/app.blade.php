<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Presenze e Assenze</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ms-3">
        <a class="navbar-brand" href="{{ url('/') }}">Calendario</a>
    </nav>
    
    <div class="container mt-4">
        @yield('content')
    </div>
    
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


<style>
    .absence-section {
        background-color: #f8d7da;
        border: 1px solid #f5c2c7;
        border-radius: 5px;
    }

    .workhour-section {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
    }

    .vh-100 {
        height: 88vh!important;
    }
</style>
