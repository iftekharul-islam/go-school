<?php

namespace App\Http\Controllers\Library;

use App\Book;
use App\Myclass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Library\BookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BookController extends Controller
{
    public function index() {
        $search = Input::get('search');
        if ($search) {
            $books = Book::bySchool(auth()->user()->school_id)->where('title','LIKE','%'.$search.'%')->paginate();
        } else {
            $books = Book::bySchool(auth()->user()->school_id)->paginate();
        }
        return view('library.books.new-index', compact('books'));
    }

    public function show($id) {
        $book = Book::findOrFail($id);
        return view('library.books.new-show', compact('book'));
    }

    public function create() {
        $classes = Myclass::where('school_id', auth()->user()->school_id)->get();

        return view('library.books.create', compact('classes'));
    }

    public function store(BookRequest $request) {
        if ($request->class_id) {
            $class_id = $request->class_id;
        } else {
            $class_id = " 12";
        }
        $book = Book::create([
            'title'     => $request->title,
            'book_code' => $request->book_code,
            'author'    => $request->author,
            'quantity'  => $request->quantity,
            'rackNo'    => $request->rackNo,
            'rowNo'     => $request->rowNo,
            'type'      => $request->type,
            'about'     => $request->about,
            'price'     => $request->price,
            'img_path'  => $request->img_path,
            'class_id'  => $class_id,
            'school_id' => auth()->user()->school_id,
            'user_id'   => auth()->user()->id
        ]);

        return redirect()->to(Auth::user()->role.'/book'.$book->id)->with('status','New book added to library');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->to(Auth::user()->role.'/all-books')->with('status', 'Book has been deleted!');
    }
}
