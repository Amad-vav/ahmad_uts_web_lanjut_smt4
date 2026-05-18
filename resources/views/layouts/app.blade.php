<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Orbitron:wght@400;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <!-- Stripe.js -->
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            window.STRIPE_KEY = "{{ env('STRIPE_KEY') }}";
        </script>
    </head>
    <body class="antialiased font-Inter" style="background: radial-gradient(ellipse at 10% 10%, rgba(99,102,241,0.12), transparent 10%), radial-gradient(ellipse at 90% 90%, rgba(236,72,153,0.08), transparent 10%), linear-gradient(180deg,#06021a,#0b1020); color: #e6eef8;">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="shadow-lg" style="backdrop-filter: blur(6px);">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="pt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        @stack('scripts')
    </body>
</html>
