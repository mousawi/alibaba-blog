<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Content -->
        <main>
            <div class="bg-white px-6 py-32 lg:px-8">
                <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl my-2">
                        {{ $article->title }}</h1>
                    <p>{{ $article->author->name }}, </p>
                    <p><time class="text-gray-500">{{ $article->publication_date->toFormattedDateString() }}</time></p>
                    {!! $article->content !!}
                </div>
            </div>

        </main>
    </div>
</body>

</html>
