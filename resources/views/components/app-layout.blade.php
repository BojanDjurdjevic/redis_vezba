<!DOCTYPE html>
<html lang="en">
<head>
    @props([
        'title' => 'vežba',
        'showHeader' => true,
    ])

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redis - {{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col dark:bg-gray-800 text-white">

    {{-- HEADER --}}
    @if ($showHeader)
        <header class="dark:bg-gray-800 text-white shadow-md">
            <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">

                <div class="text-xl font-bold text-indigo-600">
                    Redis
                </div>

                {{-- Custom header slot ako postoji --}}
                @isset($header)
                    {{ $header }}
                @else
                    {{-- Default navigation --}}
                    <nav class="space-x-6 text-sm font-medium">
                        <a href="/" class="hover:text-indigo-600 transition">Home</a>
                        <a href="/shipments" class="hover:text-indigo-600 transition">Shipments</a>
                        <a href="/shipments/create" class="hover:text-indigo-600 transition">Create Shipments</a>
                        <a href="#" class="hover:text-indigo-600 transition">About</a>
                        <a href="#" class="hover:text-indigo-600 transition">Contact</a>
                    </nav>
                @endisset

            </div>
        </header>
    @endif


    {{-- MAIN CONTENT --}}
    <main class="flex-grow max-w-6xl mx-auto w-full px-4 py-8">
        {{ $slot }}
    </main>


    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 text-sm">
        <div class="max-w-6xl mx-auto px-4 py-6 flex justify-between items-center">

            <p>
                &copy; {{ date('Y') }} Bojan. All rights reserved.
            </p>

            <div class="space-x-4">
                <a href="#" class="hover:text-white transition">Privacy</a>
                <a href="#" class="hover:text-white transition">Terms</a>
            </div>

        </div>
    </footer>

</body>
</html>