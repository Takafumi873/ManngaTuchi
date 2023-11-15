<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Comic;
use App\Models\User;

class ReviewController extends Controller
{
      public function store(Request $request, Review $review, comic $comic)
    {
        
        // dd($request);
        $input = $request['review'];
        $review->fill($input)->save();
        $comicId = $review->comic_id;
        
        return redirect()->route('show-post',['comic' => $comicId ]);
    }
}
