@extends('layouts.student-app')
@section('title', 'Edit Sector')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i>
           {{ __('text.Add New Income') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Add New Income') }}</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card false-height">
                <div class="card-body">
                    <form class="form-horizontal" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/create-income')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="name" class="mt-5">{{ __('text.sector_name') }} <label class="text-danger">*</label></label>
                                <select class="select2" id="name" name="name">
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

                                <label for="month">{{ __('text.income_date') }} <label class="text-danger">*</label></label>

                                <input data-date-format="yyyy-mm-dd" id="date" class="form-control date" name="date" value="{{ old('month') }}" placeholder="Income Date" required autocomplete="off">
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
                            <button type="submit" class="button button--save float-right">{{ __('text.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.date').datepicker({
                format: 'yyyy-mm-dd',
            });
        })
    </script>
@endsection
