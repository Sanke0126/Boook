<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at', 'DESC')->where('status', 1);
        if (!empty($request->search)) {
            $books->where('title', 'like', '%' . $request->search . '%');
        }
        $books = $books->paginate(10);
        return view('front.home', compact('books'));
    }
    public function detail($id)
    {
        $book = Book::with(['reviews.user', 'reviews' => function ($query) {
            $query->where('status', 1);
        }])->findOrFail($id);

        if ($book->status == 0) {
            abort(404);
        }
        $bookRelated = Book::where('status', 1)->take(3)->inRandomOrder(3)->where('id', '!=', $id)->get();
        return view('front.book-detail', compact('book', 'bookRelated'));
    }
    public function saveReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required|min:10',
            'rating' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        } else {
            $countReview = Review::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->count();
            if ($countReview > 0) {
                session()->flash('error', 'Your have already submitted review');
                return response()->json([
                    'status' => true,
                ]);
            }
            $bookReview = new Review;
            $bookReview->review = $request->review;
            $bookReview->rating = $request->rating;
            $bookReview->user_id = Auth::user()->id;
            $bookReview->book_id = $request->book_id;
            $bookReview->save();
            session()->flash('success', 'Your review submitted successfully');
            return response()->json([
                'status' => true,
                'message' => 'Book review submited successfully',
            ]);
        }
    }
}
