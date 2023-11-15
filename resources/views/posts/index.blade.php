<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Comic</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

       
    </head>
    <x-app-layout>
    <body class="antialiased">
        <h1>Comics</h1>
        <div class='comics' style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            @foreach ($comics as $comic)
                <div class='comic' style="border: 1px solid #ddd; padding: 10px;">
                    <h2 class='title' style="font-size: 1.5em;">
                        <a href="/posts/{{ $comic->id }}">{{ $comic->title}}</a>
                    </h2>
                    <p class='overview'>{{ $comic->overview }}</p>
                    <h3 class='released' style="font-size: 0.8em;">{{ $comic->released_at }}</h3>
                    <img src="{{ $comic->image }}" alt="Image of {{ $comic->title }}" style="max-width:100%;height:auto;">
            @auth
            <!-- Post.phpに作ったisLikedByメソッドをここで使用 -->
            @if (!$comic->isLikedBy(Auth::user()))
                <span class="likes">
                    <i class="fas fa-heart like-toggle" data-comic-id="{{ $comic->id }}"></i>
                <span class="like-counter">{{$comic->likes_count}}</span>
                </span><!-- /.likes -->
            @else
                <span class="likes">
                    <i class="fas fa-heart heart like-toggle liked" data-comic-id="{{ $comic->id }}"></i>
                <span class="like-counter">{{$comic->likes_count}}</span>
                </span><!-- /.likes -->
            @endif
            
            @if (!$comic->isReservedBy(Auth::user()))
                <span class="reserves">
                    <i class="fas fa-circle reserve-toggle" data-comic-id="{{ $comic->id }}"></i>
                </span><!-- /.likes -->
            @else
                <span class="reserves">
                    <i class="fas fa-circle reserve-toggle reserved" data-comic-id="{{ $comic->id }}"></i>
                </span><!-- /.likes -->
            @endif
            @endauth
        </div>
            @endforeach
        <form action="{{route('index')}}">
            <input type="hidden" value="1" name="understand">
            <button type="submit" name="sort" value="1">人気ランキング</button>
            <button type="submit" name="sort" value="">発売日順</button>
        </form>
        </div>
        <div class='paginate'>
            {{ $comics->appends(['understand' => 1])->links() }}
        </div>
        
        <div>
            <form action="{{ route('index') }}" method="GET">
            
            @csrf
                <input type="hidden" value="1" name="understand">
                <input type="text" name="keyword" placeholder="検索ワード">
                <input type="submit" name="検索">
            </form>
        </div>
        
         <a href='/next'>来月の発売予定</a>
        
        <h4 class="username">username:{{ Auth::user()->name }}</h4>
    </body>
    </x-app-layout>
</html>
