<?php

namespace App\Http\Controllers;

use App\School;
use App\User;
use Illuminate\Http\Request;

class MasterHomeController extends Controller
{
    public function index ()
    {
        $school = School::all()->count();
        $total_student = User::where('role', 'student')->where('active',1)->get()->count();
        $total_admin = User::where('role', 'admin')->where('active',1)->get()->count();
        return view('master-home',[
            'school'        => $school,
            'total_student' => $total_student,
            'total_admin'   => $total_admin
        ]);
    }

    public function allSchool(Request $request)
    {
        $searchData['name'] = $request->name ?? '';
        $searchData['district'] = $request->district ?? '';
        $searchData['is_sms_enable'] = '';

        if ($request->is_sms_enable){
            $searchData['is_sms_enable'] = $request->is_sms_enable;
        }

        $schools = School::when($request->name, function($query) use ($request){
                return $query->where('name', 'like', "%{$request->name}%");
            })
            ->when($request->district, function($query) use ($request){
                return $query->where('district', $request->district);
            })
            ->when($request->is_sms_enable, function($query) use ($request){
                $status = $request->is_sms_enable == 'yes' ? 1 : 0;
                return $query->where('is_sms_enable', $status);
            })
            ->orderby('name', 'asc')
            ->paginate(9);
        
        return view('school.all-school', [
            'schools' => $schools,
            'searchData' => $searchData
        ]);
    }
}
