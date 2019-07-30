<?php

namespace App\Http\Controllers;

use App\Book;
use App\Issuedbook;
use App\User;
use Illuminate\Http\Request;
use App\Services\IssueBook\IssuedBookService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IssuedbookController extends Controller
{
    protected $issuedBookService;

    public function __construct(IssuedBookService $issuedBookService){
        $this->issuedBookService = $issuedBookService;
    }
    /**
     * Show the issued books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $issuedBooks = $this->issuedBookService->getIssuedBooks();
        return view('library.new-issued-books',['issued_books'=>$issuedBooks]);
    }
    /**
     * Show all available books list so that librarian can issue books to students.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $books = Book::where('school_id', auth()->user()->school_id)
            ->where('quantity','>',0)
            ->get();
        return view('library.issuebooks',['books'=>$books]);
    }

    public function autocomplete(Request $request) {
        $data = User::where("name","LIKE","%{$request->input('query')}%")
            ->where('school_id', Auth::user()->school_id)
            ->get();
        return response()->json($data);
    }

    /**
     * Issue books to a student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'issue_date'   => 'required',
            'return_date'  => 'required',
            'book_id'      => 'required',
        ]);

        $studentExists = User::where('name',$request->name)->first();
        if($studentExists){
            $request->request->add(['student_code' => $studentExists->student_code]);
            $this->issuedBookService->request = $request;
            $this->issuedBookService->storeIssuedBooks();
            return back()->with('status', 'Book issues for  '.$studentExists->name.'');
        } else {
            return back()->with('error-status', 'Student Does Not Exist!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            DB::transaction(function () use ($request) {
            $tb = Issuedbook::findOrFail($request->issue_id);
            $tb->borrowed = 0;
            $tb->quantity = 0;
            $tb->save();
            $book = Book::where('id',$request->book_id)->first();
            $book->quantity = $book->quantity + 1;
            $book->save();
        }, 5);

        return back()->with('status', 'Saved');
    }
}
