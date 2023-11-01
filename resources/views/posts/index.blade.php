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
            @endforeach
        <form action="{{route('index')}}">
            <button type="submit" name="sort" value="1">人気ランキング</button>
            <button type="submit" name="sort" value="">発売日順</button>
        </form>
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
        
         <a href='/next'>来月の発売予定</a>
        
        <h4 class="username">username:{{ Auth::user()->name }}</h4>
    </body>
    </x-app-layout>
</html>
