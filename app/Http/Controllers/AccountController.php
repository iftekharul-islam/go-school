<?php

namespace App\Http\Controllers;

use App\AccountSector;
use App\Account;
use App\FeeTransaction;
use App\Myclass;
use App\User;
use App\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Account\StoreSectorRequest;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Services\Account\AccountService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    protected $accountSectors;

    public function __construct(AccountService $accountSectors){
        $this->accountSectors = $accountSectors;
    }

    public function sectors(){
        $sectors= $this->accountSectors->getSectorsBySchoolId();
        $this->accountSectors->account_type = 'income';
        $incomes = $this->accountSectors->getAccountsBySchoolId();
        $this->accountSectors->account_type = 'expense';
        $expenses = $this->accountSectors->getAccountsBySchoolId();
        $sector = [];
        return view('accounts.new-sector',compact('sectors','sector','incomes','expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function storeSector(StoreSectorRequest $request){
        $this->accountSectors->request = $request;
        $this->accountSectors->storeSector();

        return back()->with("status","Account Sector Created Successfully.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function editSector($id){
        $sector = AccountSector::findOrFail($id);
        return view('accounts.new-edit_sector',compact('sector'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateSector(StoreSectorRequest $request){
        $this->accountSectors->request = $request;
        $this->accountSectors->updateSector();
        return back()->with("status","Account Sector Updated Successfully.");
    }

    /**
     * Delete the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteSector($id){
        $sector = AccountSector::findOrFail($id);
        $sector->delete();
        return redirect('/accountant/sectors')->with("status","Account Sector Deleted Successfully.");
    }

    public function income(){
        $sectors = AccountSector::where('school_id', \Auth::user()->school_id)
            ->where('type','income')
            ->whereYear('created_at', date('Y'))
            ->get();
        return view('accounts.new-income',[
            'sectors'=>$sectors,
        ]);
    }
    public function storeIncome(StoreAccountRequest $request){
        $this->accountSectors->request = $request;
        $this->accountSectors->account_type = 'income';
        $this->accountSectors->storeAccount();

        return back()->with("status","Income saved Successfully.");
    }

    public function listIncome()
    {
        $incomes = Account::where('school_id', \Auth::user()->school_id)
            ->where('type','income')
            ->whereYear('created_at', date('Y'))
            ->get();
        $student_amount = FeeTransaction::where('school_id', \auth()->user()->school_id)->sum('amount');
        $student_discount = FeeTransaction::where('school_id', \auth()->user()->school_id)->sum('discount');
        $student_fine = FeeTransaction::where('school_id', \auth()->user()->school_id)->sum('fine');
        $student_total = $student_amount - $student_fine + $student_discount;
        return view('accounts.new-income-list',['incomes'=>$incomes, 'student_total' => $student_total]);
    }

    public function postIncome(Request $request)
    {
        $from = date($request->from_date);
        $to = date($request->to_date);
        $incomes = Account::where('school_id', \auth()->user()->school_id)
            ->where('type', 'income')
            ->whereBetween('date', [$from, $to])
            ->get();
        $student_amount = FeeTransaction::where('school_id', \auth()->user()->school_id)
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount');
        $student_discount = FeeTransaction::where('school_id', \auth()->user()->school_id)
            ->whereBetween('created_at', [$from, $to])
            ->sum('discount');
        $student_fine = FeeTransaction::where('school_id', \auth()->user()->school_id)
            ->whereBetween('created_at', [$from, $to])
            ->sum('fine');
        $student_total = $student_amount - $student_fine + $student_discount;
        return view('accounts.new-income-list',compact('incomes', 'from', 'to', 'student_total'));
    }

    public function editIncome($id)
    {
        $income = Account::findOrFail($id);
        return view('accounts.income-edit',compact('income'));
    }

    public function updateIncome(UpdateAccountRequest $request)
    {
        $this->accountSectors->request = $request;
        $this->accountSectors->updateAccount();

        return back()->with("status","Income Updated Successfully.");
    }

    public function deleteIncome($id)
    {
        $income = Account::findOrFail($id);
        $income->delete();

        return back()->with("status","Income Deleted Successfully.");
    }

    public function expense()
    {
        $sectors = AccountSector::where('school_id', \Auth::user()->school_id)
            ->where('type','expense')
            ->whereYear('created_at', date('Y'))
            ->get();
        return view('accounts.new-expense',['sectors'=>$sectors]);

    }
    public function storeExpense(StoreAccountRequest $request)
    {
        $this->accountSectors->request = $request;
        $this->accountSectors->account_type = 'expense';
        $this->accountSectors->storeAccount();

        return back()->with("status","Expense saved Successfully.");
    }

    public function listExpense()
    {
        $expenses = Account::where('school_id', auth()->user()->school_id)
            ->where('type', 'expense')
            ->whereYear('created_at', date('Y'))
            ->get();
        return view('accounts.new-expense-list',['expenses'=>$expenses]);
    }

    public function postExpense(Request $request)
    {
        $from = date($request->from_date);
        $to = date($request->to_date);
        $expenses = Account::where('school_id', \auth()->user()->school_id)
            ->where('type', 'expense')
            ->whereBetween('date', [$from, $to])
            ->get();
        return view('accounts.new-expense-list',compact('expenses', 'from', 'to'));
    }

    public function editExpense($id)
    {
        $expense = Account::findOrFail($id);
        return view('accounts.expense-edit',['expense'=>$expense]);
    }

    public function updateExpense(UpdateAccountRequest $request)
    {
        $this->accountSectors->request = $request;
        $this->accountSectors->updateAccount();

        return back()->with("status","Expense Updated Successfully.");
    }

    public function deleteExpense($id)
    {
        $expense = Account::findOrFail($id);
        $expense->delete();
        return back()->with("status","Expense Deleted Successfully.");
    }
}
