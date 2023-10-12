<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Review</title>
    </head>
    <x-app-layout>
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
        <input type="hidden" value="{{$comic->id}}" name="review[comic_id]"/>
        <input type="submit" value="store"/>
    </form>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
    </body>
    </x-app-layout>
</html>
