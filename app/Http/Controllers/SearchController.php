<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Review;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index (Request $request, Comic $comic)
{
    $keyword = $request->input('keyword');
    
    $comics = Comic::query();
    
    if (!empty($keyword)) 
    {
        $comics->where('title', 'LIKE', "%{$keyword}%");
    }
    
    return view('posts.index', ['comics' => $comics]);
}

}