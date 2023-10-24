<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Nextcomic;
use App\Models\Review;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ComicController extends Controller
{
    public function index(Request $request)
{
    $sort = $request->get('sort');
    $keyword = $request->input('keyword');
    
    // ユーザー情報を取得
    $user = auth()->user();

    // コミックのクエリを初期化
    $comics = Comic::withCount('likes');

    // キーワードが指定されている場合、タイトルで検索
    if (!empty($keyword)) 
    {
        $comics->where('title', 'LIKE', "%{$keyword}%");
    }

    if ($sort === '1') {
        // ソート条件が1の場合、likesの数順でコミックを取得
        $comics->orderBy('likes_count', 'DESC');
    } else {
        // ソート条件が1以外の場合、発売日順でコミックを取得
        $comics->orderBy('released_at', 'ASC');
    }

    // ページネーションを適用してコミックを取得
    $comics = $comics->paginate(5);

    return view('posts.index', ['comics' => $comics]);
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
    
    public function nextcomic()
    {
        $month = Carbon::now()->addMonth(1)->format('m');
        $comics = Comic::whereMonth('released_at',$month)->paginate(5);
        return view('posts.index')->with([ 
            'comics' => $comics,
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
        
        $comic = Comic::findOrFail($comic_id); // 特定のコミックを取得
        $comic->comic_likes_count = $comic_likes_count; // comic_likes_count フィールドに値をセット
        $comic->save(); // モデルを保存

        $param = [
            'comic_likes_count' => $comic_likes_count,
        ];
        return response()->json($param);
            
    }
    
    public function sort(Request $request)
    {
        $sort = $request->get('sort');
        if ($sort) 
        {
            if ($sort === '1') 
            {
                $comics = Comic::orderBy('comic_likes_count', 'DESC')->get();
            }
        } else 
            {
            $comics = Comic::all();
            }
            
        return view(
            'posts.index',[
                'comics' => $comics->getpaginateByLimit(),    
            ]);
    }
}
?>