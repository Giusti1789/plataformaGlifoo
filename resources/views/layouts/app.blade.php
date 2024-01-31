<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="./img/logos/Boton.ico">
    <link rel="stylesheet" href="./css/comando.css">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100" id="cuerpo">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <div class="msjerr">
            @if (session('error'))
            <div class="alert alert-danger">
                <div class="mensajes">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <div class="mensajessucess">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        </div>

       

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @yield('js')
    
</body>

</html>