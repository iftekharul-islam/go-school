<?php

namespace App\Http\Controllers;

use App\GradeSystemInfo;
use App\Http\Requests\GradeInfoRequest;
use App\Http\Requests\GradeSystemRequest;
use Illuminate\Http\Request;
use App\Gradesystem as Gradesystem;
use Illuminate\Support\Facades\Auth;

class GradesystemController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory
     * |\Illuminate\Foundation\Application|
     * \Illuminate\View\View
     */
    public function index(){

        $gpa = Gradesystem::with('gradeSystemInfo')
            ->where('school_id', \Auth::user()->school_id)
            ->first();

        return view('gpa.all',compact('gpa'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|
     * \Illuminate\Foundation\Application|
     * \Illuminate\View\View
     */
    public function create(){

        $grade_systems = Gradesystem::where('school_id', Auth::user()->school_id)->first();

        return view('gpa.new-create', compact('grade_systems'));
    }

    /**
     * @param GradeSystemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GradeSystemRequest $request){
        $data = [
            'grade_system_name' => $request->get('grade_system_name'),
            'school_id' => Auth::user()->school_id
        ];

        Gradesystem::create($data);
        return back()->with('status', 'New Grade System Added');
    }

    public function editGradeSystem($id){

        $grade_system = Gradesystem::findorFail($id);

        return view('gpa.system_edit', compact('grade_system'));
    }

    public function updateGradeSystem(Request $request, $id){


        $grade_system = Gradesystem::findorFail($id);
        $grade_system->grade_system_name = $request->grade_system_name;
        $grade_system->save();

        return redirect()->route('all.gpa')->with('status', 'Grade system name Updated!');;
    }

    public function storeGradeInfo(GradeInfoRequest $request)
    {
        $gradeExist = GradeSystemInfo::where('grade', $request->get('grade'))
            ->where('gradesystem_id', $request->get('grade_system_id'))
            ->count();

        if($gradeExist){
            return back()->with('error', 'Cannot create same grade');
        }
        $data = [
            'grade' => $request->get('grade'),
            'grade_points' => $request->get('point'),
            'marks_from' => $request->get('from_mark'),
            'marks_to' => $request->get('to_mark'),
            'gradesystem_id' => $request->get('grade_system_id'),
        ];
        GradeSystemInfo::create($data);
        return back()->with('status', 'New Grade Point Added');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $grade = GradeSystemInfo::findOrFail($id);
        return view('gpa.edit', compact('grade'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GradeInfoRequest $request, $id){
        $gpa = GradeSystemInfo::findOrFail($id);

        $gradeExist = GradeSystemInfo::where('id', '!=', $gpa->id)
            ->where('grade', $request->get('grade'))
            ->where('gradesystem_id', $gpa->gradesystem_id)
            ->count();

        if($gradeExist){
            return back()->with('error', 'Cannot create same grade');
        }

        $gpa->grade_points = $request->point;
        $gpa->grade = $request->grade;
        $gpa->marks_from = $request->from_mark;
        $gpa->marks_to = $request->to_mark;
        $gpa->save();

        return redirect()->back()->with('status', 'Grade Point info Updated !!');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        $gpa = Gradesystem::findOrFail($id);
        $gpa->delete();
        return back()->with('status', 'Grade System Deleted!');
    }
    public  function  delete($id)
    {
        $gpainfo = GradeSystemInfo::findOrFail($id);
        $gpainfo->delete();
        return redirect()->back()->with('status', 'Grade Information Data Deleted');
    }
}
