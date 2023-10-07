<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Review;

class ComicController extends Controller
{
    public function index(Comic $comic)
    {
        return view('posts.index')->with(['comics' => $comic->getpaginateByLimit()]);
    }
    
    public function show(Comic $comic)
    {
        $review = Review::all();
        //   dd($review);
        return view('posts.show')->with([
            'comic' => $comic,
            'reviews' => $review,
            ]);
        
    }
    
    public function create(Comic $comic)
    {
        return view('posts.create')->with(['comic'=>$comic]);
    }
    
    public function delete(Review $review)
    {
       $comicId = $review->comic_id;
       $review->delete();
       
        return redirect()->route('show-post',['comic' => $comicId ]);
    }
    
}
?>