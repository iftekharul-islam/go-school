<?php
namespace App\Services\Account;

use App\AccountSector;
use App\Account;

class AccountService {
    public $account_type;
    public $request;

    public function getSectorsBySchoolId(){
        return AccountSector::where('school_id', auth()->user()->school_id)->orderBy('name', 'ASC')->get();
    }

    public function getAccountsBySchoolId(){
        return Account::where('school_id', auth()->user()->school_id)
                          ->where('type', $this->account_type)
                          ->orderBy('id', 'desc')
                          ->get();
    }

    public function storeSector(){
        $sector = new AccountSector();
        $sector->name = $this->request->name;
        $sector->type = $this->request->type;
        $sector->school_id = auth()->user()->school_id;
        $sector->user_id = auth()->user()->id;
        $sector->save();
    }

    public function updateSector(){
        $sector = AccountSector::findOrFail($this->request->id);
        $sector->name = $this->request->name;
        $sector->type = $this->request->type;
        $sector->save();
    }

    public function storeAccount(){
        $income = new Account();
        $income->date = $this->request->date;
        $income->name = $this->request->name;
        $income->type = $this->account_type;
        $income->amount = $this->request->amount;
        $income->description = $this->request->description;
        $income->school_id = auth()->user()->school_id;
        $income->user_id = auth()->user()->id;
        $income->save();
    }

//    public function getAccountsByYear(){
//        return Account::where('school_id', auth()->user()->school_id)
//                          ->where('type', $this->account_type)
//                          ->whereYear('created_at',$this->request->year)
//                          ->get();
//    }
//    public function getAccountsByMonth(){
//        return Account::where('school_id', auth()->user()->school_id)
//            ->where('type', $this->account_type)
//            ->whereYear('created_at',$this->request->year)
//            ->whereMonth('created_at',$this->request->month)
//            ->get();
//    }

    public function updateAccount(){
        $account = Account::findOrFail($this->request->id);
        $account->amount = $this->request->amount;
        $account->description = $this->request->description;
        $account->save();
    }
}
