<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function add_review(Request $request){
        if($request->ajax())
        {
            $review=new \App\ad_reviews;
            $review->u_id = $request->user_id;
            $review->ad_id = $request->ad_id;
            $review->review_points = $request->rate_count;
            $review->comments = $request->u_comment;
            $review->save();
            return response()->json('success');
        }
    }

    public function load_review(Request $request){
        if($request->ajax()){
            $user_reviews=\App\ad_reviews::where('ad_id',$request->ad_id)->where('status','1')->orderby('id','desc')->limit(5)->get();
            return view('components.filters.review.user_reviews',compact('user_reviews'))->render();
        }
    }
}
