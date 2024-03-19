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
            <div class="bg-white py-16">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    @if (Route::has('filament.admin.auth.login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ route('filament.admin.pages.dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('filament.admin.auth.login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Log in
                                </a>

                                @if (Route::has('filament.admin.auth.register'))
                                    <a href="{{ route('filament.admin.auth.register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                    <div class="mx-auto max-w-3xl lg:mx-0">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Welcome to <a href="{{ route('articles.index') }}">{{ config('app.name', 'Laravel') }}</a>
                        </h2>
                        <p class="mt-2 text-lg leading-8 text-gray-600">Explore the world of travel through inspiring
                            stories, helpful tips, and unforgettable experiences.</p>
                    </div>
                    <div
                        class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">

                        @foreach ($articles as $article)
                        <article class="flex max-w-xl flex-col items-start justify-between">
                            <div class="flex items-center gap-x-4 text-xs">
                                <time class="text-gray-500">{{ $article->publication_date->toFormattedDateString() }}</time>
                            </div>
                            <div class="group relative">
                                <h3
                                    class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600 text-ellipsis">{{ strip_tags($article->content) }}</p>
                            </div>
                            <div class="relative mt-8 flex items-center gap-x-4">
                                <img src="https://ui-avatars.com/api/?name={{ $article->author->name_letters }}&amp;color=FFFFFF&amp;background=09090b"
                                    alt="" class="h-10 w-10 rounded-full bg-gray-50">
                                <div class="text-sm leading-6">
                                    <p class="font-semibold text-gray-900">
                                        <a href="#">
                                            <span class="absolute inset-0"></span>
                                            {{ $article->author->name }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </article>
                        @endforeach

                    </div>

                    {{ $articles->links('vendor.pagination.tailwind') }}

                </div>
            </div>
        </main>
    </div>
</body>

</html>
