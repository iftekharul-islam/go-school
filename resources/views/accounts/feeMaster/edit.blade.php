@extends('layouts.student-app')
@section('title', 'Fee Master')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Edit Fee Master</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Edit Fee Master</li>
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
                                <h3>Edit Fee Master</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{ url(auth()->user()->role.'/fee-master', $feeMaster->id) }}" method="post">
                            {{ csrf_field() }}
                            {!! method_field('patch') !!}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">Class</label>
                                    <select name="class_id" id="" class="select2">
                                        @foreach($classes as $class)
                                            @if($class->id === $feeMaster->class_id)
                                                <option value="{{ $class->id }}" selected>Class - {{ $class->class_number }}</option>
                                                @continue;
                                            @endif
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
                                        @foreach($feeTypes as $feeType)
                                            @if($feeMaster->fee_type_id === $feeType->id)
                                                <option value="{{ $feeType->id }}" selected>Class - {{ $feeType->name }}</option>
                                                @continue;
                                            @endif
                                            <option value="{{ $feeType->id }}">Class - {{ $feeType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Amount</label>
                                    <input type="number" step="0.01" placeholder="Amount" class="form-control" name="amount" value="{{ $feeMaster->amount }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">Due Date</label>
                                    <input type="text" class="form-control" name="dueDate" value="{{ $feeMaster->due }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">Type</label>
                                    <select name="format" id="" class="select2">
                                        @if($feeMaster->format === 'recurrent')
                                            <option value="recurrent" selected>Recurrent</option>
                                            <option value="onetime">One Time</option>
                                        @else
                                            <option value="recurrent">Recurrent</option>
                                            <option value="onetime" selected>One Time</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" class="button button--save">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection