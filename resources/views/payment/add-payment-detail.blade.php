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
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card height-auto mb-5">
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
                                        <option value="{{$school->id}}" @if(old('school_id') == $school->id) selected @endif>{{$school->name}}</option>    
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
                                <input id="sms_charge" type="text" class="form-control" name="sms_charge" value="{{old('sms_charge')}}" placeholder="0.35">
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
                                <input id="per_student_charge" type="text" class="form-control" name="per_student_charge" value="{{old('per_student_charge')}}" placeholder="5.00">
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
                                <select id="invoice_generation_date" class="form-control select2" name="invoice_generation_date" >
                                    <option disabled selected>Select Date</option>
                                    <option value="1" @if(old('invoice_generation_date')== 1) selected @endif>1</option>
                                    <option value="2" @if(old('invoice_generation_date')== 2) selected @endif>2</option>
                                    <option value="3" @if(old('invoice_generation_date')== 3) selected @endif>3</option>
                                    <option value="4" @if(old('invoice_generation_date')== 4) selected @endif>4</option>
                                    <option value="5" @if(old('invoice_generation_date')== 5) selected @endif>5</option>
                                    <option value="6" @if(old('invoice_generation_date')== 6) selected @endif>6</option>
                                    <option value="7" @if(old('invoice_generation_date')== 7) selected @endif>7</option>
                                    <option value="8" @if(old('invoice_generation_date')== 8) selected @endif>8</option>
                                    <option value="9" @if(old('invoice_generation_date')== 9) selected @endif>9</option>
                                    <option value="10" @if(old('invoice_generation_date')== 10) selected @endif>10</option>
                                    <option value="11" @if(old('invoice_generation_date')== 11) selected @endif>11</option>
                                    <option value="12" @if(old('invoice_generation_date')== 12) selected @endif>12</option>
                                    <option value="13" @if(old('invoice_generation_date')== 13) selected @endif>13</option>
                                    <option value="14" @if(old('invoice_generation_date')== 14) selected @endif>14</option>
                                    <option value="15" @if(old('invoice_generation_date')== 15) selected @endif>15</option>
                                    <option value="16" @if(old('invoice_generation_date')== 16) selected @endif>16</option>
                                    <option value="17" @if(old('invoice_generation_date')== 17) selected @endif>17</option>
                                    <option value="18" @if(old('invoice_generation_date')== 18) selected @endif>18</option>
                                    <option value="19" @if(old('invoice_generation_date')== 19) selected @endif>19</option>
                                    <option value="20" @if(old('invoice_generation_date')== 20) selected @endif>20</option>
                                    <option value="21" @if(old('invoice_generation_date')== 21) selected @endif>21</option>
                                    <option value="22" @if(old('invoice_generation_date')== 22) selected @endif>22</option>
                                    <option value="23" @if(old('invoice_generation_date')== 23) selected @endif>23</option>
                                    <option value="24" @if(old('invoice_generation_date')== 24) selected @endif>24</option>
                                    <option value="25" @if(old('invoice_generation_date')== 25) selected @endif>25</option>
                                    <option value="26" @if(old('invoice_generation_date')== 26) selected @endif>26</option>
                                    <option value="27" @if(old('invoice_generation_date')== 27) selected @endif>27</option>
                                    <option value="28" @if(old('invoice_generation_date')== 28) selected @endif>28</option>
                                    <option value="29" @if(old('invoice_generation_date')== 29) selected @endif>29</option>
                                    <option value="30" @if(old('invoice_generation_date')== 30) selected @endif>30</option>
                                </select>
                                @if ($errors->has('invoice_generation_date'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('invoice_generation_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="email" class="control-label false-padding-bottom">Email<label class="text-danger">*</label></label>
                                <input id="email" type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('due_date') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="due_date" class="control-label false-padding-bottom">Payment Due Date</label>
                                <input id="due_date" type="text" data-date-format="yyyy-mm-dd" class="form-control date" name="due_date" value="{{old('due_date')}}" placeholder="Payment Due Date">
                                @if ($errors->has('due_date'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('due_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" id="registerBtn" class="button button--save float-right">
                            Add Payment Info
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
@endsection

