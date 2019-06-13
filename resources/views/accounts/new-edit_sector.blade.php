@extends('layouts.student-app')
@section('title', 'Edit Sector')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Hostel List</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Edit Sector</li>
        </ul>
    </div>
    <div class="card height-auto" style="min-height: 700px;">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>
                    <h3>Edit Sector</h3>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @isset($sector)
                <form class="new-added-form justify-content-md-center" action="{{url('accounts/update-sector')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$sector->id}}">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label mt-5">Sector Name</label>

                        <div class="col-md 12">
                            <input id="name" type="text" class="form-control" name="name" value="{{$sector->name}}" placeholder="Sector Name" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label for="type" class="col-md-4 control-label">Sector Type: {{ucfirst($sector->type)}} (Current)</label>

                        <div class="col-md-12">
                            <select class="form-control" name="type">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>

                            @if ($errors->has('type'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('type') }}</strong>
                              </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </form>
            @endisset
        </div>
    </div>
@endsection
