@extends('layouts.student-app')
@section('title', 'Add Expense')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i>
            {{ __('text.add_expense') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.add_expense') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <form class="new-added-form justify-content-md-center" action="{{url(current_user()->role.'/create-expense')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="name" class=" mt-5">{{ __('text.expense_name') }} <label class="text-danger">*</label></label>

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
                            <div class="col-md-12">
                                <label for="amount">{{ __('text.amount') }} <label class="text-danger">*</label></label>
                                <input id="amount" type="number" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Amount" required>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('amount') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="date">{{ __('text.Date') }}<label class="text-danger">*</label></label>

                                <input type="date" id="date" class="form-control date" name="date" value="{{ old('month') }}" placeholder="Expense Date" required>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('date') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="description">{{ __('text.description') }} <label class="text-danger">*</label></label>
                                <textarea rows="3" id="description" class="form-control" name="description" placeholder="Description" required>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('description') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="button button--save float-right"><b>{{ __('text.save') }}</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
