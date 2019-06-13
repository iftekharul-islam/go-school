@extends('layouts.student-app')
@section('title', 'Edit Sector')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Add New Income</li>
        </ul>
    </div>
    <div class="card height-auto" s<div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false">...</a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>tyle="min-height: 700px;">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>
                    <h3>Add Income</h3>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-horizontal" action="{{url('accounts/create-income')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 mt-5">Sector Name</label>
                    <div class="col-md-12">
                        <select class="form-control" id="name" name="name">
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
                    <label for="amount" class="col-md-4">Amount</label>

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
                    <label for="description" class="col-md-4">Description</label>

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
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection