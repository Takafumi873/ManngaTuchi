<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <x-app-layout>
    <head>
        <meta charset="utf-8">
        <title>Review</title>
    </head>
    <body>
        <h1>Comic　name</h1>
        <form action="/posts" method="POST">
            @csrf
            <div class='title'>
                <h2>Title</h2>
                <input type="text" name="review[title]" placeholder="タイトル"/>
            </div>
        <div class='body'>
            <h2>body</h2>
            <textarea name="review[body]" placeholder="面白かった。"></textarea>
        </div>
        <input type="hidden" value="{{ $comic->id }}" name="review[comic_id]">
        <input type="hidden" value="{{ Auth::user()->id }}" name="review[user_id]">
        <input type="submit" value="送信">
    </form>
　　<form action="{{route('index')}}">
        <button type="submit" name="understand" value="1">戻る</button>
    </form>
    </body>
    </x-app-layout>
</html>
