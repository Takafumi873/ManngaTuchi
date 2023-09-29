<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Comic</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

       
    </head>
    <body class="antialiased">
        <h1>Comics</h1>
        <div class='comics'>
            @foreach ($comics as $comic)
            <div class='comic'>
                <h2 class='title'>{{ $comic->title }}</h2>
                <p class='overview'>{{ $comic->body }}</p>
                <h3 class='released'>{{ $comic->created_at }}</h3>
            </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $comics->links() }}
        </div>
    </body>
</html>
