<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>来月発売予定の本</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

       
    </head>
    <x-app-layout>
    <body class="antialiased">
        <h1>Comics</h1>
        <div class='comics'>
            @foreach ($nextcomics as $nextcomic)
            <div class='comic'>
                <p class='title'>{{ $nextcomic->title }}</p>
                <p class='overview'>{{ $nextcomic->overview }}</p>
                <h3 class='released'>{{ $nextcomic->released_at }}</h3>
                <a href='/posts/notification/{{$nextcomic->id}}'>購入予定</a>
            </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $comics->links() }}
        </div>
        
        <div>
            <form action="{{ route('index') }}" method="GET">
            
            @csrf
            
                <input type="text" name="keyword" placeholder="検索ワード">
                <input type="submit" name="検索">
            </form>
        </div>
        
        <h4 class="username">username:{{ Auth::user()->name }}</h4>
    </body>
    </x-app-layout>
</html>
                  