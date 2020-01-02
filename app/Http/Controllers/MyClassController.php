<?php

namespace App\Http\Controllers;

use App\Myclass as Myclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ClassResource;

class MyClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($school_id)
    {
        return ($school_id > 0) ? ClassResource::collection(Myclass::where('school_id', $school_id)->get()) : response()->json([
            'Invalid School id: '.$school_id,
            404,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_number' => 'required',
        ]);
        $tb = new Myclass();
        $tb->class_number = $request->class_number;
        $tb->school_id = Auth::user()->school_id;
        $tb->group = (! empty($request->group)) ? $request->group : '';
        $tb->department_id = (! empty($request->department)) ? $request->department : 0;
        $tb->save();

        return back()->withInput(['tab' => 'tab8'])->with('status', 'New Class created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ClassResource(Myclass::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tb = Myclass::findOrFail($id);
        $tb->class_number = $request->class_number;
        $tb->school_id = $request->school_id;

        return ($tb->save()) ? response()->json([
            'status' => 'success',
        ]) : response()->json([
            'status' => 'error',
        ]);
    }
    public function updateClassDetails(Request $request, $id) {
         $class = Myclass::findOrFail($id);
         $class->class_number = $request->get('class_number');
         $class->group = $request->get('group') ? $request->get('group') : '';
         $class->department_id = $request->get('department') ? $request->get('department') : 0;
         if ($class->save()) {
             return back()->with('status', 'Class info updated!');
         }
         return back()->with('error', 'Something went wrong! Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Myclass::destroy($id)) ? response()->json([
            'status' => 'success',
        ]) : response()->json([
            'status' => 'error',
        ]);
    }
}
