<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $review = Review::with('book', 'user')->orderBy('created_at', 'DESC')->paginate(10);
        return view('review.list', compact('review'));
    }
    public function edit($id)
    {
        $review = Review::find($id);
        return view('review.edit', compact('review'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('review.edit', $id)->withInput()->withErrors($validator);
        }
        $review = Review::find($id);
        $review->review = $request->review;
        $review->status = $request->status;
        $review->save();
        return redirect()->route('review.index')->with('success', 'Your Review Updated successfully');
    }
    public function destroy(Request $request)
    {
        $review = Review::find($request->id);
        if ($review == null) {
            session()->flash('error', 'Review not deleted');
            return response()->json([
                'status' => false
            ]);
        } else {
            $review->delete();
            session()->flash('success', 'Review deleted successfully');
            return response()->json([
                'status' => true
            ]);
        }
    }
}
