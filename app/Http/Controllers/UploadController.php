<?php

namespace App\Http\Controllers;
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
//use App\Http\Controllers\UploadHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Event;
use App\Notice;
use App\Syllabus;
use App\Routine;
use Illuminate\Support\Facades\Auth;
/*
 * jQuery File Upload Plugin PHP Class
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

class UploadController extends Controller {
    public function upload(Request $request){
        $request->validate([
            'upload_type' => 'required',
            'file' => 'required|max:1024|mimes:doc,docx,png,jpeg,pdf,xlsx,xls,ppt,pptx,txt'
        ]);

        $authUser = Auth::user();

        $upload_dir = 'school-'.$authUser->school_id.'/'.date("Y").'/'.$request->upload_type;
        $path = Storage::disk('public')->putFile($upload_dir, $request->file('file'));//$request->file('file')->store($upload_dir);

        if($request->upload_type == 'notice'){
            $request->validate([
                'title' => 'required|string',
            ]);

            $tb = new Notice;
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = $authUser->school_id;
            $tb->user_id = $authUser->id;
            $tb->save();
        }
        else if($request->upload_type == 'event'){
            $request->validate([
                'title' => 'required|string',
            ]);
            $tb = new Event;
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = $authUser->school_id;
            $tb->user_id = $authUser->id;
            $tb->save();
        } else if($request->upload_type == 'routine'){
            $request->validate([
                'title' => 'required|string',
            ]);
            $tb = new Routine;
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = $authUser->school_id;
            $tb->user_id = $authUser->id;
            $tb->section_id = $request->section_id;
            $tb->save();
        } else if($request->upload_type == 'syllabus'){
            $request->validate([
                'title' => 'required|string',
            ]);
            $tb = new Syllabus;
            $tb->file_path = 'storage/'.$path;
            $tb->title = $request->title;
            $tb->active = 1;
            $tb->school_id = $authUser->school_id;
            $tb->user_id = $authUser->id;
            $tb->class_id = $request->section_id;
            $tb->save();
        } else if($request->upload_type == 'profile' && $request->user_id > 0){
            $tb = User::findOrFail($request->user_id);
            $tb->pic_path = 'storage/'.$path;
            $tb->save();
        }

        return ($path)?response()->json([
            'imgUrlpath' => url('storage/'.$path),
            'path' => 'storage/'.$path,
            'error' => false
        ]):response()->json([
            'imgUrlpath' => null,
            'path' => null,
            'error' => true
        ]);
        // $options = ['upload_dir'=>'','upload_url'=>''];
        // new UploadHandler($options);
    }
}
