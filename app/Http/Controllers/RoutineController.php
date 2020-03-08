<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoutineUploadRequest;
use App\Myclass;
use App\Syllabus;
use App\Routine as Routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\RoutineResource;
use Illuminate\Support\Facades\Storage;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $section_id = $user->role == 'student' ? $user->section_id : '';
        $files = Routine::with('section.class')
            ->where('school_id', Auth::user()->school_id)
            ->where('active', 1)
            ->when($section_id, function($query) use ($section_id){
                $query->where('section_id', $section_id);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('routines.index', ['files' => $files, 'section_id' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $section_id)
    {
//      return Syllabus::all();
        try {
            if (Schema::hasColumn('routines', 'section_id')) {
                $files = Routine::with('section')
                    ->where('school_id', Auth::user()->school_id)
                    ->where('section_id', $section_id)
                    ->where('active', 1)
                    ->get();
            } else {
                return '<code>section_id</code> column missing. Run <code>php artisan migrate</code>';
            }
        } catch (Exception $ex) {
            return 'Something went wrong!!';
        }
//      return $files;
        return view('routines.new-create', ['files' => $files, 'section_id' => $section_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $tb = new Routine();
        $tb->file_path = $request->file_path;
        $tb->title = $request->title;
        $tb->active = 1;
        $tb->school_id = $user->school_id;
        $tb->user_id = $user->id;
        $tb->save();

        return back()->with('status', 'Routine upload complete');
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
        return new RoutineResource(Routine::find($id));
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
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $tb = Routine::findOrFail($id);
        1 == $tb->active ? $tb->active = 0 : $tb->active = 1;
        $tb->save();

        return back()->with('status', 'Routine status changed');
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
        return (Routine::destroy($id)) ? response()->json([
            'status' => 'success',
        ]) : response()->json([
            'status' => 'error',
        ]);
    }
    public function upload()
    {
        $classes = Myclass::with('sections')
            ->where('school_id', Auth::user()->school_id)
            ->orderBy('class_number', 'ASC')
            ->get();
        return view('routines.upload', compact('classes'));
    }

    public function storeRoutine(RoutineUploadRequest $request)
    {

        $upload_dir = 'school-'.Auth::user()->school_id.'/'.date("Y").'/routine';
        $path = Storage::disk('public')->putFile($upload_dir, $request->file('file'));
        $path = 'storage/'.$path;

        $data = [
            'section_id' => $request->get('section'),
            'file_path' => $path,
            'title' => $request->get('title'),
            'active' => 1,
            'school_id' => Auth::user()->school_id,
            'user_id' => Auth::user()->id,

        ];
         Routine::create($data);
        return back()->with('status', 'New Routine added successfully!');

    }
}
