<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\CreateIssueBooksRequest;
use App\Issuedbook;
use App\Myclass;
use App\User;
use Illuminate\Http\Request;
use App\Services\IssueBook\IssuedBookService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IssuedbookController extends Controller
{
    protected $issuedBookService;

    public function __construct(IssuedBookService $issuedBookService)
    {
        $this->issuedBookService = $issuedBookService;
    }

    /**
     * Show the issued books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issued_books = $this->issuedBookService->getIssuedBooks();

        return view('library.new-issued-books', ['issued_books' => $issued_books]);
    }

    /**
     * Show all available books list so that librarian can issue books to students.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::where('school_id', auth()->user()->school_id)->where('quantity', '>', 0)->get();
        $classes = Myclass::with('sections.students')->where('school_id', Auth::user()->school_id)->get();
        $class_number = $data->class->class_number ?? '';

        return view('library.issue-books', compact('books', 'classes', 'class_number'));
    }

    public function autocomplete(Request $request)
    {
        $data = User::where("name", "LIKE", "%{$request->input('query')}%")->where('school_id', Auth::user()->school_id)->get();
        return response()->json($data);
    }

    /**
     * Issue books to a student.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIssueBooksRequest $request)
    {
        $studentExists = User::find($request->student_id);

        if ($studentExists) {
            $request->request->add(['student_code' => $studentExists->student_code]);
            $this->issuedBookService->request = $request;
            $this->issuedBookService->storeIssuedBooks();

            return redirect()->route('issued-books')->with('status', 'Book issues for  ' . $studentExists->name );

        } else {

            return back()->with('error-status', 'Student Does Not Exist!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {

            $tb = Issuedbook::findOrFail($request->issue_id);
            $tb->borrowed = 0;
            $tb->quantity = 0;
            $tb->save();

            $book = Book::where('id', $request->book_id)->firstOrFail();
            $book->quantity = $book->quantity + 1;
            $book->save();
        }, 5);

        return back()->with('status', 'Book Returned successfully !');
    }

    /**
     * @return Issuedbook[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function returnHistory()
    {
        $books = Issuedbook::with('book', 'student.section.class')
            ->where('school_id', auth()->user()->school_id)
            ->where('borrowed', 0)
            ->where('quantity', 0)
            ->paginate(20);

        return view('library.returned-books', compact('books'));

    }
}
