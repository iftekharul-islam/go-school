<?php

namespace App\Http\Controllers\Library;

use App\Book;
use App\Http\Requests\BookUpdateRequest;
use App\Myclass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Library\BookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $search = Input::get('search');
        if ($search) {
            $books = Book::bySchool(auth()->user()->school_id)->where('title', 'LIKE', '%' . $search . '%')->paginate();
        } else {
            $books = Book::bySchool(auth()->user()->school_id)->paginate();
        }
        return view('library.books.new-index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('library.books.new-show', compact('book'));
    }

    public function create()
    {
        $classes = Myclass::where('school_id', auth()->user()->school_id)->get();

        return view('library.books.create', compact('classes'));
    }

    public function store(BookRequest $request)
    {
        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('storage/book/');
            $image->move($destinationPath, $image_name);
            $path = 'book/' . $image_name;
        }
        $data = [
            'title' => $request->title,
            'book_code' => $request->book_code,
            'author' => $request->author,
            'quantity' => $request->quantity,
            'rackNo' => $request->rackNo,
            'rowNo' => $request->rowNo,
            'type' => $request->type,
            'about' => $request->about,
            'price' => $request->price,
            'img_path' => $request->img_path ? 'storage/' . $path : '',
            'class_id' => $request->class_id ?? $request->class_id,
            'school_id' => auth()->user()->school_id,
            'user_id' => auth()->user()->id
        ];
        $book = Book::create($data);

        return redirect()->to(Auth::user()->role . '/book/' . $book->id)->with('status', 'New book added to library');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->to(Auth::user()->role . '/all-books')->with('status', 'Book has been deleted!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $classes = Myclass::where('school_id', Auth::user()->school_id)->get();
        return view('library.books.edit-book', compact('book', 'classes'));
    }

    public function update(BookUpdateRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->title = $request->get('title');
        $book->author = $request->get('author');
        $book->rackNo = $request->get('rackNo');
        $book->rowNo = $request->get('rowNo');
        $book->about = $request->get('about');
        $book->quantity = $request->get('quantity');
        $book->price = $request->get('price');

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('storage/book/');
            $image->move($destinationPath, $image_name);
            $path = 'book/' . $image_name;
            $book->img_path = 'storage/' . $path;
        }

        $book->type = $request->get('type');
        $book->class_id = $request->get('class_id') ? $request->get('class_id') : '';
        if ($book->save()) {
            return redirect()->to(Auth::user()->role . '/all-books')->with('status', 'Book information updated');
        }
        return back()->with('error', 'Something went wrong please try again');
    }
}
