@extends('layouts.student-app')

@section('title', 'Edit Information')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit Information
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit Information</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <form class="new-added-form" method="POST" enctype="multipart/form-data" action="{{ route('update-user-info', $user->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Full Name</label>
                            <input class="form-control" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="control-label false-padding-bottom">Gender</label>
                            <select id="gender" class="form-control" name="gender">
                                <option class="text-capitalize" value="male" selected="selected">Male</option>
                                <option class="text-capitalize" value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('father_name') ? ' has-error' : '' }}">
                            <label for="father-name">Fathers Name</label>
                            <input class="form-control" name="father_name" value="{{ $user->studentInfo['father_name'] }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('mother_name') ? ' has-error' : '' }}">
                            <label for="mother-name">Mothers Name</label>
                            <input class="form-control" name="mother_name" value="{{ $user->studentInfo['mother_name'] }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('blood_group') ? ' has-error' : '' }}">
                            <label for="blood_group">Blood Group</label>
                            <select id="blood_group" class="form-control" name="blood_group">
                                <option selected="selected">{{ $user->blood_group }}</option>
                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('religion') ? ' has-error' : '' }}">
                            <label for="religion">Religion</label>
                            <select id="religion" class="form-control" name="religion">
                                <option selected="selected">Islam</option>
                                <option>Hinduism</option>
                                <option>Christianism</option>
                                <option>Buddhism</option>
                                <option>Other</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('father_occupation') ? ' has-error' : '' }}">
                            <label for="father-name">Fathers Occupation</label>
                            <input class="form-control" name="father_occupation" value="{{ $user->studentInfo['father_occupation'] }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('mother_occupation') ? ' has-error' : '' }}">
                            <label for="mother-name">Mothers Occupation</label>
                            <input class="form-control" name="mother_occupation" value="{{ $user->studentInfo['mother_occupation'] }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('father_designation') ? ' has-error' : '' }}">
                            <label for="father-name">Fathers Designation</label>
                            <input class="form-control" name="father_designation" value="{{ $user->studentInfo['father_designation'] }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('mother_designation') ? ' has-error' : '' }}">
                            <label for="mother-name">Mothers Designation</label>
                            <input class="form-control" name="mother_designation" value="{{ $user->studentInfo['mother_designation'] }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="name">Address</label>
                            <textarea class="form-control" name="address" value="{{ $user->address }}">{{ $user->address }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('about') ? ' has-error' : '' }}">
                            <label for="name">About</label>
                            <textarea class="form-control" name="about" value="{{ $user->about }}">{{ $user->about }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label mr-2">Upload Profile Picture</label>
                                <input type="file" id="picPath" name="pic_path">
                            </div>
                        </div>
                    </div>
                   <div class="col-md-6 col-sm-12">
                       <div class="form-group">
                           <button type="submit" id="registerBtn" class="button button--save float-right">Update Information</button>
                       </div>
                   </div>
                </div>
            </form>
        </div>
    </div>
@endsection
