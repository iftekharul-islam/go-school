@extends('layouts.student-app')

@section('title', 'Add Form Field')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Accounts</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Add New Expense</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Add Expense Area Start Here -->
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                    <h3>Add Form Field</h3>
                </div>
            </div>
            <form class="new-added-form" action="{{url('fees/create')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12 form-group{{ $errors->has('fee_name') ? ' has-error' : '' }}">
                        <label>Field Name</label>
                        <input type="text" placeholder="Form Field Name" name="fee_name" value="{{ old('fee_name') }}" class="form-control" required>
                        @if ($errors->has('fee_name'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('fee_name') }}</strong>
                                  </span>
                        @endif
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
