<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Comic</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

       
    </head>
    <x-app-layout>
    <body class="antialiased">
        <h1>Comics</h1>
        <div class='comics'>
            @foreach ($comics as $comic)
            <div class='comic'>
                <h2 class='title'>
                    <a href="/posts/{{ $comic->id }}">{{ $comic->title}}</a>
                </h2>
                <p class='overview'>{{ $comic->overview }}</p>
                <h3 class='released'>{{ $comic->released_at }}</h3>
            </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $comics->links() }}
        </div>
        <div>{{ Auth::user()->name }}</div>
    </body>
    </x-app-layout>
</html>
