@extends('layouts.student-app')

@section('title', 'Add Payment Information')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fa fa-usd"></i>
            Add Payment Information
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add Payment Information</li>
        </ul>
    </div>
    <div class="card height-auto mb-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-body">
            <form class="new-added-form" method="POST" enctype="multipart/form-data" id="attendanceTime" action="{{ route('store.payment.info') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('school_id') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="school_id" class="control-label false-padding-bottom">School<label class="text-danger">*</label></label>
                                <select id="school_id" class="form-control select2" name="school_id" >
                                    <option value="" disabled selected>Select School</option>
                                    @foreach ($schools as $school)
                                        <option value="{{$school->id}}">{{$school->name}}</option>    
                                    @endforeach
                                </select>
                                @if ($errors->has('school_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('school_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('sms_charge') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="sms_charge" class="control-label false-padding-bottom">SMS Charge(Per SMS)<label class="text-danger">*</label></label>
                                <input id="sms_charge" type="number" class="form-control" name="sms_charge" value="{{ old('sms_charge') }}">
                                @if ($errors->has('sms_charge'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sms_charge') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('per_student_charge') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="per_student_charge" class="control-label false-padding-bottom">Per Student Charge<label class="text-danger">*</label></label>
                                <input id="per_student_charge" type="number" class="form-control" name="per_student_charge" value="{{ old('per_student_charge') }}">
                                @if ($errors->has('per_student_charge'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('per_student_charge') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('invoice_generation_date') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="invoice_generation_date" class="control-label false-padding-bottom">Invoice Generation Date<label class="text-danger">*</label></label>
                                <input id="invoice_generation_date" type="date" class="form-control" name="invoice_generation_date" value="{{ old('invoice_generation_date') }}">
                                @if ($errors->has('invoice_generation_date'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('invoice_generation_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" id="registerBtn" class="button button--save float-right">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
@endsection

@push('customjs')
    <script>   
  
    </script>
@endpush
