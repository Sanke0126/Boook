<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at', 'DESC');
        if (!empty($request->keyword)) {
            $books->where('title', 'like', '%' . $request->keyword . '%');
        }
        $books = $books->paginate(10);
        return view('books.list', compact('books'));
    }
    public function create()
    {
        return view('books.add');
    }
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:10',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        if ($request->book_image != '') {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('books.add')->withInput()->withErrors($validator);
        }
        if ($request->book_image != '') {
            $imageName = time() . '.' . $request->book_image->extension();
            $request->book_image->storeAs('public/books', $imageName);
        } else {
            $imageName = '';
        }
        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->image = $imageName;
        $book->save();
        $manager = new ImageManager(Driver::class);
        $img = $manager->read('storage/books/' . $imageName);
        $img->cover(200, 200);
        $img->save('storage/books/thumb/' . $imageName);
        return redirect()->route('books.index')->with('success', 'Your Book added successfully');
    }

    public function edit($id)
    {
        $book = Book::find($id);
        return view('books.update', compact('book'));
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|min:10',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        if ($request->book_image != '') {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('books.edit', $id)->withInput()->withErrors($validator);
        }
        $book = Book::find($id);
        if ($request->book_image != '') {
            File::delete('storage/books/' . $book->image);
            File::delete('storage/books/thumb/' . $book->image);
            $imageName = time() . '.' . $request->book_image->extension();
            $request->book_image->storeAs('public/books', $imageName);
            $manager = new ImageManager(Driver::class);
            $img = $manager->read('storage/books/' . $imageName);
            $img->cover(200, 200);
            $img->save('storage/books/thumb/' . $imageName);
        } else {
            $imageName = $book->image;
        }
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->image = $imageName;
        $book->save();
        return redirect()->route('books.index')->with('success', 'Your Book added successfully');
    }
    public function destroy(Request $request)
    {
        $book = Book::find($request->id);
        if ($book == null) {
            session()->flash('error', 'Book not found');
            return response()->json([
                'status' => false,
                'message' => 'Book not found'
            ]);
        } else {
            File::delete('storage/books/' . $book->image);
            File::delete('storage/books/thumb/' . $book->image);
            $book->delete();
            session()->flash('success', 'Book deleted successfully');
            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully '
            ]);
        }
    }
}
