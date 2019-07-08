@extends('layouts.student-app')
@section('title', 'Edit Sector')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            </a>Add New Expense
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add New Expense</li>
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
                    <form class="new-added-form justify-content-md-center" action="{{url('accounts/create-expense')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 mt-5">Sector Name</label>

                            <div class="col-md-12">
                                <select  class="select2" name="name">
                                    @foreach($sectors as $sector)
                                        <option>{{$sector->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-2">Amount</label>

                            <div class="col-md-12">
                                <input id="amount" type="number" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Amount" required>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('amount') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-2">Description</label>

                            <div class="col-md-12">
                                <textarea rows="3" id="description" class="form-control" name="description" placeholder="Description" required>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('description') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="button button--save float-left text-uppercase"><b>Save</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection