@extends('layouts.student-app')

@section('title', 'Edit Department')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-microscope'></i>
            Edit {{ $department->department_name }} Department
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>{{ $department->department_name }} Department</li>
        </ul>

        <div class="row">
            <div class="col-12">
                <div class="card height-auto false-height">
                    <div class="card-body">
                        <form method="POST" id="department" action="{{ route('admin.department.update', $department->id) }}">
                            {{ method_field('PATCH') }}
                           {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">

                                        <label for="departmentName"
                                               class="control-label false-padding-bottom">Department Name</label>

                                        <input id="department_name" type="text"
                                               class="form-control" name="department_name"
                                               value="{{ $department->department_name ?? old('department_name') }}">

                                        @if ($errors->has('department_name'))
                                            <span class="help-block"><strong>{{ $errors->first('department_name') }}</strong></span>
                                        @endif

                                    </div>

                                    <button class="btn btn-primary" type="submit">Update</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
