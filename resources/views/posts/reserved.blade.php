<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <x-app-layout>
        <div class="antialiased">
            <h1>購入予定の新刊</h1>
            <div class='comics' style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                @foreach ($comics as $comic)
                <div class='comic' style="border: 1px solid #ddd; padding: 10px;">
                    <h2 class='title' style="font-size: 1.5em;">
                        <a href="/posts/{{ $comic->id }}">{{ $comic->title}}</a>
                    </h2>
                    <p class='overview'>{{ $comic->overview }}</p>
                    <h3 class='released' style="font-size: 0.8em;">{{ $comic->released_at }}</h3>
                    <img src="{{ $comic->image }}" alt="Image of {{ $comic->title }}" style="max-width:100%;height:auto;">
                </div>
                @endforeach
                <form action="{{ route('index') }}">
                    <button type="submit" name="understand" value="1">確認</button>
                </form>
            </div>
        </div>
    </x-app-layout>
</body>

</html>
