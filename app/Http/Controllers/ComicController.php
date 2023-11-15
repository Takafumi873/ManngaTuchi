<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Review;
use App\Models\User;
use App\Models\Like;
use App\Models\Reserve;
use App\Services\RakutenService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ComicController extends Controller
{
   public function nextcomic(Request $request)
{
    $month = Carbon::now()->addMonth(1)->format('m');
    
    $comics = Comic::whereMonth('released_at', $month)
              ->get();
              
    return view('posts.nextIndex', ['comics' => $comics]);
}

    public function index(Request $request)
{
    $sort = $request->get('sort');
    $understand = $request->get('understand');
    $keyword = $request->input('keyword');
    $days = [];
    $now = Carbon::now();

    for ($i = 0; $i <= 7; $i++) {
        $days[] = $now->copy()->addDays($i)->format('Y-m-d');
    }

    
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
        $comics->orderBy('released_at', 'DESC');
    }

    // ページネーションを適用してコミックを取得
    $comics = $comics->paginate(12);

    $reserveComicIds = Reserve::where('user_id', $user->id)->pluck('comic_id')->toArray();
    
    $reservedComics = Comic::whereIn('id', $reserveComicIds)
                            ->whereIn('released_at', $days)
                            ->get();
                            //dd($reservedComics);
    $count = count($reservedComics);
    //dd($count);
    
    if ($understand != 1) {
        if ($count==0) {
        return view('posts.index', ['comics' => $comics]);
        } else {
            //dd("a");
        return view('posts.reserved', ['comics' => $reservedComics]);
        }
    } else {
        return view('posts.index', ['comics' => $comics]);
        }

    
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
    
   public function reserve(Request $request, Comic $comic)
    {
        
        //Log::debug("a");
        
        $user_id = Auth::user()->id;
        $comic_id = $request->comic_id;
        //dd($comic_id);
        //Log::debug($comic_id);
        $already_reserved = Reserve::where('user_id', $user_id)->where('comic_id', $comic_id)->first();
        
        if (!$already_reserved) {
        Log::debug($comic_id);
            $reserve = new Reserve;
            $reserve->comic_id = $comic_id;
            $reserve->user_id = $user_id;
            $reserve->save();
        } else {
            Reserve::where('comic_id', $comic_id)->where('user_id', $user_id)->delete();
            
        }
        
        return view(
            'posts.index',[
                'comics' => $comic->getpaginateByLimit(),    
            ]);
            
    }
    
      public function updateComicData()
    {
        $apiEndpoint = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404';
        $apiKey = '1099989328861075116';
    
        $genreId = 10169; // この数値はコミックジャンルの例です。適切なジャンルに置き換えてください。
    
        // クエリパラメータを設定
        $query = [
            'format' => 'json',
            'applicationId' => $apiKey,
            'size' => '9', // ジャンルをコミックに設定
            'publisherName' => '集英社', // 出版社名を指定
        ];
    
        // APIリクエストを送信
        $response = Http::get($apiEndpoint, $query);
    
        // JSONレスポンスをデコード
        $data = $response->json();
        //dd($data);
        $mangaList = array_slice($data['Items'], 0, 30);
        
        function convertJapaneseDateToISO($dateString) {
        $formatted = str_replace(['年', '月', '日'], '-', $dateString);
        $formatted = rtrim($formatted, '-');

        // 日付部分を分割して、不正なフォーマットをチェック
        $dateParts = explode('-', $formatted);
        if (count($dateParts) >= 3) {
            // "2021年12月1日" は "2021-12-1" に変換される
            return implode('-', array_slice($dateParts, 0, 3));
        }
    
        // 不正な日付フォーマットの場合は null を返す
        return null;
        }

        
        foreach ($mangaList as $mangaItem) {
        $manga = $mangaItem['Item'];
        $comic = new Comic();
        $comic->title = $manga['title'];
        
         $isoDate = convertJapaneseDateToISO($manga['salesDate']);
        if ($isoDate) {
            $comic->released_at = Carbon::parse($isoDate);
        } else {
            // 日付の変換が失敗した場合の処理
            continue; // または他のエラーハンドリング
        }
        
        $comic->image = $manga['mediumImageUrl'];
        $comic->save();
    };

    }
}
?>