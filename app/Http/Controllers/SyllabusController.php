<?php

namespace App\Http\Controllers;

use App\Http\Requests\SyllabusUploadRequest;
use App\Myclass;
use Illuminate\Http\Request;
use App\Syllabus as Syllabus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\SyllabusResource;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Syllabus::with('myclass')
            ->where('school_id', Auth::user()->school_id)
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('syllabus.index', ['files' => $files, 'class_id' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $class_id)
    {
        try {
            if (Schema::hasColumn('syllabuses', 'class_id')) {
                $files = Syllabus::with('myclass')
                    ->where('school_id', \Auth::user()->school_id)
                    ->where('class_id', $class_id)
                    ->where('active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            } else {
                return '<code>class_id</code> column missing. Run <code>php artisan migrate</code>';
            }
        } catch (Exception $ex) {
            return 'Something went wrong!!';
        }

        return view('syllabus.new-course-syllabus', ['files' => $files, 'class_id' => $class_id]);
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
        $tb = new Syllabus;
        $tb->file_path = $request->file_path;
        $tb->title = $request->title;
        $tb->active = 1;
        $tb->school_id = \Auth::user()->school_id;
        $tb->user_id = \Auth::user()->id;
        $tb->save();

        return back()->with('status', 'Uploaded');
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
        return new SyllabusResource(Syllabus::findOrFail($id));
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
        $tb = Syllabus::findOrFail($id);
        1 == $tb->active ? $tb->active = 0 : $tb->active = 1;
        $tb->save();

        return back()->with('status', 'Syllabus Status Changed');
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
        return (Syllabus::destroy($id)) ? response()->json([
            'status' => 'success',
        ]) : response()->json([
            'status' => 'error',
        ]);
    }

    public function upload()
    {
        $classes = Myclass::where('school_id', Auth::user()->school_id)->get();
        return view('syllabus.upload', compact('classes'));
    }

    public function storeSyllabus(SyllabusUploadRequest $request)
    {

        $upload_dir = 'school-'.Auth::user()->school_id.'/'.date("Y").'/syllabus';
        $path = Storage::disk('public')->putFile($upload_dir, $request->file('file'));
        $path = 'storage/'.$path;
        $data = [
          'file_path'  => $path,
          'title' => $request->get('syllabus_title'),
          'active' => 1,
          'school_id' =>Auth::user()->school_id,
          'class_id' => $request->get('class'),
          'user_id' => Auth::user()->id
        ];
        Syllabus::create($data);
        return back()->with('status', 'Syllabus created successfully');
    }

    public function syllabusForStudentTeaher()
    {
        $syllabuses  = '';
        $class_id = null;
        $user = Auth::user();
        if ($user->role == 'student') {
            $user->load('section.class');
            $class_id = !empty($user['section']['class']) ? $user['section']['class']['id'] : null;
        }

        $syllabuses = Syllabus::with('myclass')
            ->where('school_id', Auth::user()->school_id)
            ->where('active', 1)
            ->when($class_id, function($query) use ($class_id) {
                return $query->where('class_id', $class_id);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
            
        return view('syllabus.syallabus-for-student-teacher', compact('syllabuses'));
    }
}
