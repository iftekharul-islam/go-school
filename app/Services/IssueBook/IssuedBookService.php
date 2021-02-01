<?php
namespace App\Services\IssueBook;

use App\Issuedbook;
use App\Book;

class IssuedBookService {
    public $request;
    public $ib;

    public function getIssuedBooks(){
        return Issuedbook::with('book', 'student')
            ->where('school_id',  auth()->user()->school->id)
            ->paginate(config('pagination.default_pagination'));
    }

    /**
     * Insert each issued book to an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertEachIssuedBookInAnArray(){
        foreach ($this->request->book_id as $bk){
            $issueBooks = new Issuedbook;
            $issueBooks->student_code = $this->request->student_code;
            $issueBooks->book_id = $bk;
            $issueBooks->quantity = 1;
            $issueBooks->school_id = auth()->user()->school->id;
            $issueBooks->issue_date = $this->request->issue_date;
            $issueBooks->return_date = $this->request->return_date;
            $issueBooks->fine = 0;//$this->request->fine;
            $issueBooks->borrowed = 1;
            $issueBooks->user_id = auth()->user()->id;
            $this->ib[] = $issueBooks->attributesToArray();
        }
    }

    public function storeIssuedBooks(){
        $this->insertEachIssuedBookInAnArray();

        \DB::transaction(function () {
            Issuedbook::insert($this->ib);
            Book::whereIn('id',$this->request->book_id)->update([
                'quantity' => \DB::raw('coalesce((quantity - 1), 0) ')
            ]);
        });
    }
}
