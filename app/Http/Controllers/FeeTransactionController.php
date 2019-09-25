<?php

namespace App\Http\Controllers;

use App\Discount;
use App\FeeMaster;
use App\FeeTransaction;
use App\Myclass;
use App\Section;
use App\Services\User\UserService;
use App\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;

class FeeTransactionController extends Controller
{
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'discountAmount' => 'required',
            'fine' => 'required',
        ]);
        $feeMaster = FeeMaster::find($request->feeMasterId);
        $user = FeeTransaction::where('student_id', 19)->where('fee_master_id', $request->feeMasterId)->get();

        $value = $request->amount;
        $amount = $request->amount;

        if ($value === $feeMaster->amount) {
            $status = 'Paid';
        }
        elseif ($value > 0 && $value < $feeMaster->amount) {
            $status = 'Partial';
        }
        else {
            $status = 'Unpaid';
        }

        $ft = new FeeTransaction();
        $ft->student_id = $request->get('student_id');
        $ft->amount = $amount;
        $ft->discount_id = $request->get('discount');
        $ft->discount = $request->get('discountAmount');
        $ft->fine = $request->get('fine');
        $ft->mode = $request->get('mode');
        $ft->fee_master_id = $request->get('feeMasterId');
        $ft->accountant_id = Auth::id();
        $ft->school_id = \auth()->user()->school_id;
        $ft->status = $status;
        $ft->save();
        $tm = new App\TransactionMonth();
        $tm->month = $request->month;
        $tm->fee_transaction_id = $ft->id;
        $tm->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FeeTransaction::findOrFail($id)->delete();
        App\TransactionMonth::where('fee_transaction_id', $id)->delete();
        return redirect()->back();
    }

    public function feeCollection()
    {
        $classes = Myclass::with('sections')->get();
        return view('accounts.transaction.index', compact('classes'));
    }

    public function sectionsStudent(Request $request)
    {
        $classes = Myclass::with('sections')->get();
        $students = $this->userService->getSectionStudentsWithSchool($request->section);
        return view('accounts.transaction.sectionStudents', compact('students', 'classes'));
    }

    public function collectFee($id)
    {
        $student = User::with(['studentInfo', 'section', 'section.class.feeMasters', 'section.class.feeMasters.feeType', 'section.class.feeMasters.transactions', 'section.class.feeMasters.transactions.transactionMonths'])->where('id', $id)->first();
        $discounts = Discount::all();
//        return $student;
        return view('accounts.transaction.feeCollect', compact('student', 'discounts'));
    }

    public function multipleFee($id)
    {
        $student = User::with(['studentInfo', 'section', 'section.class.feeMasters', 'section.class.feeMasters.feeType', 'section.class.feeMasters.transactions'])->where('id', $id)->first();
        $discounts = Discount::all();
        return view('accounts.transaction.multiple-fee', compact('student', 'discounts'));
    }

    public function multipleFeeStore(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'discountAmount' => 'required',
            'fine' => 'required',
        ]);
        foreach ($request->feeMasterId as $item) {
            $myArray = explode(',', $item);
        }

        $ft = new FeeTransaction();
        $ft->student_id = $request->student_id;
        $ft->school_id = \auth()->user()->school_id;
        $ft->amount = $request->amount;
        $ft->discount = $request->discountAmount;
        $ft->fine = $request->fine;
        $ft->mode = $request->mode;
        $ft->accountant_id = \auth()->id();
        $ft->status = 'paid';
        $ft->fee_master_id = $myArray[0];
        $ft->save();
        foreach ($request->month as $item) {
            $tm = new App\TransactionMonth();
            $tm->month = $item;
            $tm->fee_transaction_id = $ft->id;
            $tm->save();
        }

//        $index = 0;
//        foreach ($myArray as $key => $value) {
//            $ft = new FeeTransaction();
//            $fm = FeeMaster::find($value);
//            $amount = $fm->amount;
//
//            if ($fm->format === 'recurrent') {
//                $ft->student_id = $request->student_id;
//                $ft->school_id = \auth()->user()->school_id;
//                $ft->amount = $amount;
//                $ft->discount = $request->discountAmount;
//                $ft->fine = $request->fine;
//                $ft->mode = $request->mode;
//                $ft->accountant_id = \auth()->id();
//                $ft->status = 'paid';
//                $ft->fee_master_id = $value;
//                $ft->save();
//                $index++;
//            } else {
//                $ft->student_id = $request->student_id;
//                $ft->school_id = \auth()->user()->school_id;
//                $ft->amount = $amount;
//                $ft->discount = $request->discountAmount;
//                $ft->fine = $request->fine;
//                $ft->mode = $request->mode;
//                $ft->accountant_id = \auth()->id();
//                $ft->status = 'paid';
//                $ft->fee_master_id = $value;
//                $ft->save();
//            }
//        }
        return redirect()->to(\auth()->user()->role.'/fee-collection/get-fee/'.$request->student_id);
    }
}
