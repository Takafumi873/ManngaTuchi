<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <x-app-layout>
    <body class="antialiased">
        <h1>a</h1>
        <h1 class="title">
            {{ $comic->title }}
        </h1>
        <div class="content">
            <div class="content_post">
                <h2>あらすじ</h2>
                <p>{{ $comic->overview }}</p>
            </div>
        </div>
        <a href='/posts/create/{{$comic->id}}'>create</a>
        @foreach ($comic->reviews as $review)
        <h1 class="review title">
            {{ $review->title }}
        </h1>
            <div class="review">
                <p>{{ $review->body }}</p>
                <form action="/posts/{{ $review->id }}" id="form_{{ $review->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $review->id }})">delete</button>
                </form>
            </div>
        @endforeach
        <script>
            function deletePost(id) {
                'use strict'
                
                if (confirm('削除すると復元できません。\n本当に削除しますか？'))　{
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
    </x-app-layout>
</html>
