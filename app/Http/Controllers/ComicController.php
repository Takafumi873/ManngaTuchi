<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Review;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class ComicController extends Controller
{
    public function index(Comic $comic)
    {
        $user = auth()->user();
        $comics = Comic::withcount('likes')->orderByDesc('released_at')->get();
        return view('posts.index', [
            'comics' => $comic->getpaginateByLimit(),
            ]);
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
        return view('posts.create')->with([
            'comic'=>$comic,
            ]);
    }
    
    public function delete(Review $review)
    {
       $comicId = $review->comic_id;
       $review->delete();
       
        return redirect()->route('show-post',['comic' => $comicId ]);
    }
    
    public function like(Request $request)
    {
        $user_id = Auth::user()->id;
        $comic_id = $request->comic_id;
        // dd($comic_id);
        $already_liked = Like::where('user_id', $user_id)->where('comic_id', $comic_id)->first();
        
        if (!$already_liked) {
            $like = new Like;
            $like->comic_id = $comic_id;
            $like->user_id = $user_id;
            $like->save();
        } else {
            Like::where('comic_id', $comic_id)->where('user_id', $user_id)->delete();
        }
        
        $comic_likes_count = Comic::withCount('likes')->findOrFail($comic_id)->likes_count;
        $param = [
            'comic_likes_count' => $comic_likes_count,
        ];
        return response()->json($param);
            
    }
    
    
}
?>