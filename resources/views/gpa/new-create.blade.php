@extends('layouts.student-app')
@section('title', 'Add GPA System')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Create new Grade System
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Create new Grade System</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
{{--            <div class="heading-layout1">--}}
{{--                <div class="item-title">--}}
{{--                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>--}}
{{--                    <h3>Add GPA System</h3>--}}
{{--                </div>--}}
{{--            </div>--}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="new-added-form" action="{{url('create-gpa')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-8-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade_system_name') ? ' has-error' : '' }}">
                        <label>Grade System Name</label>
                        <input id="grade_system_name" type="text" class="form-control" name="grade_system_name" value="{{ old('grade_system_name') }}" placeholder="Grade System Name" required>

                        @if ($errors->has('grade_system_name'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('grade_system_name') }}</strong>
                                  </span>
                        @endif
                    </div>
                    <div class="col-8-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
                        <label>Grade</label>
                        <input id="grade" type="text" class="form-control" name="grade" value="{{ old('grade') }}" placeholder="A+, A, A-, B+, ..." required>

                        @if ($errors->has('grade'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('grade') }}</strong>
                                  </span>
                        @endif
                    </div>
                    <div class="col-8-xxxl col-lg-6 col-12 form-group{{ $errors->has('point') ? ' has-error' : '' }}">
                        <label>Grade Point</label>
                        <input id="point" type="text" class="form-control" name="point" value="{{ old('point') }}" placeholder="5.00, 4.50, ..." required>

                        @if ($errors->has('point'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('point') }}</strong>
                                  </span>
                        @endif
                    </div>
                    <div class="col-8-xxxl col-lg-6 col-12 form-group{{ $errors->has('from_mark') ? ' has-error' : '' }}">
                        <label>From Mark</label>
                        <input id="from_mark" type="text" class="form-control" name="from_mark" value="{{ old('from_mark') }}" placeholder="Example: 80" required>

                        @if ($errors->has('from_mark'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('from_mark') }}</strong>
                                  </span>
                        @endif
                    </div>
                    <div class="col-8-xxxl col-lg-6 col-12 form-group{{ $errors->has('to_mark') ? ' has-error' : '' }}">
                        <label>To Mark</label>
                        <input id="to_mark" type="text" class="form-control" name="to_mark" value="{{ old('to_mark') }}" placeholder="Example: 90" required>

                        @if ($errors->has('to_mark'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('to_mark') }}</strong>
                                  </span>
                        @endif
                    </div>

                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="button1 button1--white button1--animation float-left">Save</button>
                        <a href="javascript:history.back()" class="button1 button1--white button1--animation float-left" style="margin-left: 2%; background-color: white; color: #269589; border: 1px solid !important;" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
