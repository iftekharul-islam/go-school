@extends('layouts.student-app')
@section('title', 'Edit GPA System')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit Grade System
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit Grade System</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card height-auto false-height">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="new-added-form" action="{{url('admin/update-gpa', $grade->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
                                <label>Grade</label>
                                <input id="grade" type="text" class="form-control" name="grade" value="{{ $grade->grade }}" required>

                                @if ($errors->has('grade'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('grade') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('point') ? ' has-error' : '' }}">
                                <label>Grade Point</label>
                                <input id="point" type="text" class="form-control" name="point" value="{{ $grade->grade_points }}" placeholder="5.00, 4.50, ..." required>

                                @if ($errors->has('point'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('point') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('from_mark') ? ' has-error' : '' }}">
                                <label>From Mark</label>
                                <input id="from_mark" type="text" class="form-control" name="from_mark" value="{{ $grade->marks_from }}" placeholder="Example: 80" required>

                                @if ($errors->has('from_mark'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('from_mark') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('to_mark') ? ' has-error' : '' }}">
                                <label>To Mark</label>
                                <input id="to_mark" type="text" class="form-control" name="to_mark" value="{{ $grade->marks_to }}" placeholder="Example: 90" required>

                                @if ($errors->has('to_mark'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('to_mark') }}</strong>
                                  </span>
                                @endif
                            </div>

                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="button button--save float-right"><b>Update</b></button>
                                <a href="{{ URL::previous() }}" class="button button--cancel float-right mr-3"  role="button"><b>Cancel</b></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
