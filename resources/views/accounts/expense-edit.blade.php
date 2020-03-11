@extends('layouts.student-app')
@section('title', 'Edit Expense')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="breadcrumbs-area">
            <h3>Edit Expense</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Manage Accounts</li>
                <li><a href="{{ route('expenseList') }}"> Expense List</a></li>
                <li>Edit Expense</li>
            </ul>
        </div>

        <div class="col-md-12" id="main-container">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-body">
                        <div class="card height-auto false-height">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Edit Expense</h3>
                                    </div>
                                </div>
                                <form class="new-added-form" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/update-expense')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$expense->id}}">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">Sector Name <label class="text-danger">*</label></label>

                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="{{$expense->name}}" placeholder="Sector Name" required>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                  <strong>{{ $errors->first('name') }}</strong>
                                              </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <label for="amount" class="col-md-4 control-label">Amount <label class="text-danger">*</label></label>

                                        <div class="col-md-12">
                                            <input id="amount" type="text" class="form-control" name="amount" value="{{$expense->amount}}" placeholder="Amount" required>

                                            @if ($errors->has('amount'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('amount') }}</strong>
                                  </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <label for="description" class="col-md-4 control-label">Description <label class="text-danger">*</label></label>

                                        <div class="col-md-12">
                              <textarea id="description" class="form-control"
                                        rows="3"
                                        name="description" placeholder="Description" required>{{$expense->description}}</textarea>

                                            @if ($errors->has('description'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('description') }}</strong>
                                  </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <button type="submit" class="button button--save">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
@endsection
