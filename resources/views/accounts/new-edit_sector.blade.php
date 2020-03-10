@extends('layouts.student-app')
@section('title', 'Edit Sector')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i> Edit Sector</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li>Edit Sector</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto" style="min-height: 700px; width: 60%;">
        <div class="card-body">
            @isset($sector)
                <form class="new-added-form justify-content-md-center" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/update-sector')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$sector->id}}">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label mt-5">Sector Name <label class="text-danger">*</label></label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{$sector->name}}" placeholder="Sector Name" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label for="type" class="col-md-4 control-label">Sector Type <label class="text-danger">*</label></label>
                        <div class="col-md-8">
                            <select class="form-control" name="type">
                                <option value="expense" @if($sector->type == 'expense') selected @endif >Expense</option>
                                <option value="income" @if($sector->type == 'income') selected @endif >Income</option>
                            </select>

                            @if ($errors->has('type'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('type') }}</strong>
                              </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="button button--save">Update Sector</button>
                    </div>
                </form>
            @endisset
        </div>
    </div>
@endsection
