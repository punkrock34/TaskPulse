<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', 'TaskPulse') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            statusMessage: "{{ session('status') }}",
            errorMessage: "{{ session('error') }}",
            errors: <?php echo json_encode($errors->all()); ?>
        };
    </script>
</body>
</html>
