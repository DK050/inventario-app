<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        {{-- Si tienes algún CSS global personalizado que no sea Tailwind, agrégalo aquí --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/custom-global.css') }}"> --}}

        <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
        }
        .modal-overlay-bg {
            transition: opacity 0.3s ease;
        }
        .modal-content {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
    </head>
    <body class="font-sans antialiased">
        {{-- Contenedor principal para el sidebar y el contenido --}}
        <div class="flex h-screen bg-gray-100 dark:bg-gray-900"> {{-- Ajusta el color de fondo de Breeze si es necesario --}}

            {{-- Aquí incluimos tu Sidebar --}}
            @include('layouts.sidebar') {{-- Asegúrate de crear este archivo: resources/views/layouts/sidebar.blade.php --}}

            {{-- Contenedor principal para el contenido (header de Breeze + slot) --}}
            <div class="flex-1 flex flex-col overflow-hidden">
                @isset($header)
                    <header class="bg-white shadow page-header-breeze"> {{-- Cambiado bg-white a bg-gray-800 o similar --}}
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content-wrapper"> {{-- Mantén los fondos de Breeze si los quieres como base, o cámbialos --}}
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
