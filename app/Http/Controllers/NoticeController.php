<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\NoticeRequest;
use App\Notice;
use App\Http\Resources\NoticeResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notice_data = Notice::query();
        $event_data = Event::query();
        $user = Auth::user();

        $notices = $this->selectedData($notice_data, $user);

        $events = $this->selectedData($event_data, $user);

        return view('notices.index', compact('notices', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $data = Notice::query();
        $role = Auth::user()->role;

        if ($role != 'admin') {
            $user_role = user_role($role);

            $data->where('roles', 'like', '%' . "\"{$user_role}\"" . '%')
                ->orWhere('roles', null);
        }

        $files = $data->where('school_id', Auth::user()->school_id)
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('notices.list', ['files' => $files]);
    }

    public function create()
    {
        return view('notices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeRequest $request)
    {
        $user = Auth::user();
        $path = $request->hasFile('file_path') ? Storage::disk('public')->put('school-' . $user->school_id . '/' . date('Y'), $request->file('file_path')) : null;

        $tb = new Notice;
        $tb->file_path = $path ? 'storage/' . $path : '';
        $tb->title = $request->title;
        $tb->description = $request->description;
        $tb->active = 1;
        $tb->school_id = $user->school_id;
        $tb->user_id = $user->id;
        $tb->roles = isset($request->roles) ? serialize($request->roles) : null;
        $tb->save();

        return redirect()->route('academic.notice')->with('status', __('text.event_upload_notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return roles_value(3);
        $data = Notice::query();
        $user = Auth::user();

        if ($user->role != 'admin') {
            $user_role = user_role($user->role);

            $data->where('roles', 'like', '%' . "\"{$user_role}\"" . '%')
                ->orWhere('roles', null);
        }

        $notices = $data->where('school_id', Auth::user()->school_id)
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        $notice = '';
        $roles = '';
        if ($notices->isNotEmpty()) {
            foreach ($notices as $item) {
                if ($item['id'] == $id) {
                    $notice = $item;
                    $roles = unserialize($item->roles);
                }
            }
        }

        return view('notices.show', compact('notices', 'notice', 'roles'));
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
    public function update($id)
    {
        $tb = Notice::findOrFail($id);
        $tb->active == 1 ? $tb->active = 0 : $tb->active = 1;
        $tb->save();
        return back()->with('status', 'Notice Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Notice::destroy($id)) ? response()->json([
            'status' => 'success'
        ]) : response()->json([
            'status' => 'error'
        ]);
    }

    public function deleteNotice($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->file_path) {
            Storage::disk('public')->delete($notice->file_path);
        }
        $notice->delete();

        return back()->with('status', 'Notice Deleted');
    }

    /**
     * @param $data
     * @param $user
     * @return mixed
     */
    public function selectedData($data, $user)
    {
        if ($user->role != 'admin') {
            $user_role = user_role($user->role);
            $data->where('roles', 'like', '%' . "\"{$user_role}\"" . '%')
                ->orWhere('roles', null);
        }

        return $data->where('school_id', $user->school_id)
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

}
