@extends('layouts.student-app')

@section('title', 'Add Form Field')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Add Expense
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add Expense</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Add Expense Area Start Here -->
    <div class="card height-auto false-height">
        <div class="card-body">
            <form class="new-added-form" action="{{url('fees/create')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-8 form-group{{ $errors->has('fee_name') ? ' has-error' : '' }}">
                        <label>Field Name</label>
                        <input type="text" placeholder="Form Field Name" name="fee_name" value="{{ old('fee_name') }}" class="form-control" required>
                        @if ($errors->has('fee_name'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('fee_name') }}</strong>
                                  </span>
                        @endif
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="button button--save float-left"><b>Save</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
