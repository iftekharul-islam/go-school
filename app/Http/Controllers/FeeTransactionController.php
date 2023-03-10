<?php

namespace App\Http\Controllers;

use App\Discount;
use App\FeeMaster;
use App\FeeTransaction;
use App\Myclass;
use App\StudentInfo;
use App\Configuration;
use App\Services\User\UserService;
use App\User;
use App\FeeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Events\ReceiptGenerate;
use App\TransactionItem;
use PDF;
use App\Http\Requests\CreateMultipleFeeStoreRequest;

class FeeTransactionController extends Controller
{
    public function __construct(UserService $userService)
    {
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
     * @param \Illuminate\Http\Request $request
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
        $studentInfo = StudentInfo::where('user_id', $request->get('student_id'))->first();

        if ($request->get('advance_amount')) {
            $studentInfo->advance_amount += $request->get('advance_amount');
            $studentInfo->save();
        }

        $value = $request->amount;
        $amount = $request->amount;
        $deducted_advance_amount = 0;

        if ($request->get('pay_from_advance_blnc') == 1) {
            $totalAmount = $request->get('totalAmount') + $request->get('fine') - $request->get('discountAmount');
            if ($totalAmount < $studentInfo->advance_amount) {
                $studentInfo->advance_amount = $studentInfo->advance_amount - $totalAmount;
                $amount = $totalAmount;
                $deducted_advance_amount = $totalAmount;
            } else {
                $collectiveAmount = $studentInfo->advance_amount + $request->get('amount');
                $amount = $collectiveAmount;
                $deducted_advance_amount = $studentInfo->advance_amount;
                $studentInfo->advance_amount = 0;
            }
            $studentInfo->save();
        }

        if ($value === $feeMaster->amount) {
            $status = 'Paid';
        } elseif ($value > 0 && $value < $feeMaster->amount) {
            $status = 'Partial';
        } else {
            $status = 'Unpaid';
        }

        $ft = new FeeTransaction();
        $ft->student_id = $request->get('student_id');
        $ft->amount = $amount;
        $ft->discount_id = $request->get('discount');
        $ft->discount = $request->get('discountAmount');
        $ft->fine = $request->get('fine');
        $ft->mode = $request->get('mode');
        $ft->accountant_id = Auth::id();
        $ft->school_id = \auth()->user()->school_id;
        $ft->status = $status;
        $ft->deducted_advance_amount = $deducted_advance_amount;
        $ft->save();
        $ft->feeMasters()->attach($request->feeMasterId);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ft = FeeTransaction::findOrFail($id);
        $studentInfo = StudentInfo::where('user_id', $ft->student_id)->first();
        if (empty($studentInfo)) {
            return redirect()->back()->with('status', 'Student information not found');
        }
        $studentInfo->advance_amount += $ft->deducted_advance_amount;
        $studentInfo->save();
        $transaction_items = TransactionItem::where('fee_transaction_id', $id)->delete();
        $ft->delete();

        return redirect()->back();
    }

    public function feeCollection()
    {
        $classes = Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get();
        return view('accounts.transaction.index', compact('classes'));
    }

    public function sectionsStudent(Request $request)
    {
        $class_id = $request->class_id ?? '';
        $classes = Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get();
        $students = $this->userService->getSectionStudents($request->section);
        $selected_class = isset($class_id) ? $classes->first(function ($item) use ($class_id) {
            return $item->id == $class_id;
        }) : '';

        return view('accounts.transaction.section_students', compact('students', 'classes', 'class_id', 'selected_class'));
    }

    public function collectFee($id)
    {
        $student = User::with(['studentInfo', 'section', 'section.class.feeMasters', 'section.class.feeMasters.feeType'])->where('id', $id)->first();
        $discounts = Discount::where('school_id', Auth::user()->school_id)->get();

        return view('accounts.transaction.feeCollect', compact('student', 'discounts'));
    }

    public function multipleFee($id)
    {
        $student = User::with(['studentInfo', 'section', 'section.class.feeMasters', 'section.class.feeMasters.feeType'])->where('id', $id)->first();
        $discounts = Discount::where('school_id', Auth::user()->school_id)->get();
        $feeTypes = FeeType::where('school_id', Auth::user()->school_id)->orWhere('is_default', 1)->orderBy('name', 'asc')->get();
        $months = full_year_by_month();

        return view('accounts.transaction.multiple_fee', compact('student', 'discounts', 'feeTypes', 'months'));
    }

    public function feeCollections($id)
    {
        $student = User::with(['school', 'studentInfo', 'section.class'])->findOrFail($id);
        $fees = FeeTransaction::with('transaction_items.fee_type')->where('student_id', $id)->get();

        return view('accounts.transaction.fee_collections', compact('fees', 'student'));
    }

    public function multipleFeeStore(CreateMultipleFeeStoreRequest $request)
    {
        $serial = '';
        $school_id = Auth::user()->school_id;
        $amount = $request->amount;
        $payable = $request->payable;
        $deducted_advance_amount = 0;
        $studentInfo = StudentInfo::where('user_id', $request->get('student_id'))->first();

        #update advance balance
        if ($request->get('payFromAdv') == 1) {
            if ($payable < $studentInfo->advance_amount) {
                $studentInfo->advance_amount = $studentInfo->advance_amount - $payable;
                $deducted_advance_amount = $payable;
            } else {
                $deducted_advance_amount = $studentInfo->advance_amount;
                $studentInfo->advance_amount = 0;
            }
            $studentInfo->save();
        }

        #transaction serial
        $transaction_serial = Configuration::where('key', 'transaction_serial')
            ->where('school_id', $school_id)->first();
        if (!empty($transaction_serial)) {
            $serial = $transaction_serial->value + 1;
            $transaction_serial->value = $serial;
            $transaction_serial->save();
        } else {
            $config = new Configuration();
            $config->key = 'transaction_serial';
            $config->value = 0001;
            $config->school_id = $school_id;
            $config->save();
            $serial = 1;
        }

        #save transaction
        $ft = new FeeTransaction();
        $ft->transaction_serial = $serial;
        $ft->student_id = $request->student_id;
        $ft->school_id = \auth()->user()->school_id;
        $ft->amount = $amount;
        $ft->discount_id = $request->discount;
        $ft->discount = $request->discount_amount;
        $ft->fine = $request->fine ?? 0;
        $ft->mode = $request->mode;
        $ft->accountant_id = \auth()->id();
        $ft->status = 'paid';
        $ft->deducted_advance_amount = $deducted_advance_amount;
        $ft->save();

        #save fee types & amount
        $selected_fees = $request->get('selected_fees');
        for ($i = 0; $i < count($selected_fees); $i++) {
            $fee_id = $selected_fees[$i];
            $from = $request->get($fee_id . '_from') != null ? $request->get($fee_id . '_from') : '';
            $to = $request->get($fee_id . '_to') != null ? $request->get($fee_id . '_to') : '';
            $transactionItem = new TransactionItem();

            if (!empty($from) && !empty($to)) {
                $transactionItem->note = $from . ' - ' . $to;
            }

            $transactionItem->fee_transaction_id = $ft->id;
            $transactionItem->fee_type_id = $fee_id;
            $transactionItem->fee_amount = $request->get($fee_id . '_amount');

            $transactionItem->save();
        }

        return redirect(Auth::user()->role . '/transaction-detail/' . $ft->id)
            ->with('status', 'Fee collected successfully');
    }

    public function studentFeeDetails()
    {
        $fees = FeeTransaction::with('transaction_items')->where('student_id', Auth::user()->id)->get();

        return view('fees.fees_summary', compact('fees') );
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function transactionDetail(Request $request, $id)
    {
        $transaction = FeeTransaction::with('transaction_items.fee_type')->findOrFail($id);
        $student = User::with(['school', 'section.class', 'studentInfo'])->findOrFail($transaction->student_id);
        $total_amount = 0;

        foreach ($transaction->transaction_items as $item) {
            $total_amount += $item->fee_amount;
        }

        $grand_total = $total_amount + $transaction->fine - $transaction->discount;
        $partial = $grand_total - ($transaction->amount + $transaction->deducted_advance_amount);
        $due_amount = number_format(($grand_total - ($partial + $transaction->deducted_advance_amount) ), 2);

        if ($request->print == 1) {
            $this->generateReceipt($student, $transaction, $total_amount, $partial, $grand_total);
        }

        return view('accounts.transaction.transaction_detail', compact('transaction', 'student', 'total_amount', 'partial', 'grand_total', 'due_amount'));
    }

    public function advanceCollection(Request $request)
    {
        $searchData['student_name'] = $request->student_name;
        $searchData['class_id'] = $request->class_id;
        $searchData['section_id'] = $request->section_id;
        $classes = Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get();

        $students = User::with('feeTranscation', 'studentInfo', 'section.class')
            ->where('role', 'student')
            ->where('school_id', Auth::user()->school_id)
            ->where('active', 1)
            ->when($request->section_id, function ($query) use ($request) {
                return $query->where('section_id', $request->section_id);
            })
            ->when($request->student_name, function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->student_name}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(30);

        return view('accounts.advance-collections', compact('students', 'classes', 'searchData'));
    }

    public function updateAdvanceAmount(Request $request)
    {
        $request->validate([
            'student_code' => 'required',
            'advanceAmount' => 'required|numeric'
        ]);
        $student = StudentInfo::where('student_id', $request->student_code)->first();
        $student->advance_amount = $request->advanceAmount;
        $student->save();

        return back()->with('status', 'Advance Amount Updated');
    }

    public function generateReceipt($student, $transaction, $total_amount, $partial, $grand_total)
    {
        $partial_amount = number_format(( $grand_total - ($transaction->amount + $transaction->deducted_advance_amount) ), 2);
        $due_amount = number_format(($grand_total - ($partial + $transaction->deducted_advance_amount) ), 2);

        $data = ['student_name' => $student['name'],
            'roll_number' => $student['studentInfo']['roll_number'],
            'section' => $student['section']['section_number'],
            'class' => $student['section']['class']['class_number'],
            'transaction' => $transaction,
            'school_name' => $student['school']['name'],
            'school_address' => $student['school']['school_address'],
            'total_amount' => $total_amount,
            'partial' => $partial,
            'partial_amount' => $partial_amount,
            'due_amount' => $due_amount,
            'grand_total' => $grand_total,

        ];
        $pdf = PDF::loadView('accounts.transaction.receipt-template', $data, [], ['format' => 'A4-L', 'orientation' => 'L']);
        $date = Carbon::now();
        $pdfName = $student['student_code'] . '_' . $student['name'] . '_' . $date->format('Y-m-d_g-i-a') . '_receipt.pdf';
        $pdf->stream($pdfName);
    }
}
