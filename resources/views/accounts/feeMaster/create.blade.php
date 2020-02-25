@extends('layouts.student-app')
@section('title', 'Fee Master')
@section('content')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Create Fee Master</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Manage Accounts</li>
                <li><a href="{{  url(auth()->user()->role.'/fee-master') }}">Fee Master</a></li>
                <li>Add Fee Master </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create Fee Master</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{ url(auth()->user()->role.'/fee-master') }}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">Class</label>
                                    <select name="class_id" id="" class="select2">
                                        <option value="" selected>Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">Class - {{ $class->class_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Fee Type</label>
                                    <select name="fee_type" id="" class="select2">
                                        <option value="" selected>Select Fee</option>
                                        <option value="recurrent">Monthly</option>
                                        @foreach($feeTypes as $feeType)
                                            <option value="{{ $feeType->id }}">{{ $feeType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Amount</label>
                                    <input type="number" step="0.01" placeholder="Amount" class="form-control" name="amount" value="{{ old('amount') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4" id="name_data">
                                    <label for="desc">Due Date <small>( <b>Select type before due date</b> )</small></label>
                                    <input type="text" data-date-format="yyyy-mm-dd" id="due_date" class="form-control date" name="dueDate" value="{{ old('dueDate') }}" placeholder="Date of Collect Fee">
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" role="button" class="button button--save">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
