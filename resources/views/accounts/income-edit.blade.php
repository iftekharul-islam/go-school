@extends('layouts.student-app')
@section('title', 'Edit Income')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Edit Expense Section</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Add Expense Area Start Here -->
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Edit Expense</h3>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="new-added-form" action="{{url('accounts/update-income')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$income->id}}">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Sector Name</label>

                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control" name="name" value="{{$income->name}}" placeholder="Sector Name" required>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('name') }}</strong>
                                  </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                    <label for="amount" class="col-md-4 control-label">Amount</label>

                    <div class="col-md-12">
                        <input id="amount" type="text" class="form-control" name="amount" value="{{$income->amount}}" placeholder="Amount" required>

                        @if ($errors->has('amount'))
                            <span class="help-block">
                                      <strong>{{ $errors->first('amount') }}</strong>
                                  </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description" class="col-md-4 control-label">Description</label>

                    <div class="col-md-12">
                              <textarea id="description" class="form-control"
                                        rows="3"
                                        name="description" placeholder="Description" required>{{$income->description}}</textarea>

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


{{--<div class="container-fluid">--}}
{{--    <div class="row">--}}
{{--        <div class="breadcrumbs-area">--}}
{{--            <h3>Dashboard</h3>--}}
{{--            <ul>--}}
{{--                <li>--}}
{{--                    <a href="{{ url('/home') }}">Home</a>--}}
{{--                </li>--}}
{{--                <li>Edit Expense Section</li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--        <div class="col-md-12" id="main-container">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">Edit Income</div>--}}

{{--                <div class="panel-body">--}}
{{--                        <div class="card height-auto false-height">--}}
{{--                            <div class="card-body">--}}
{{--                                @if (session('status'))--}}
{{--                                    <div class="alert alert-success">--}}
{{--                                        {{ session('status') }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                    @isset($income)--}}
{{--                                        <form class="form-horizontal" action="{{url('accounts/update-income')}}" method="post">--}}
{{--                                            {{ csrf_field() }}--}}
{{--                                            <input type="hidden" name="id" value="{{$income->id}}">--}}
{{--                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
{{--                                                <label for="name" class="col-md-4 control-label">Sector Name</label>--}}

{{--                                                <div class="col-md-6">--}}
{{--                                                    <input id="name" type="text" class="form-control" name="name" value="{{$income->name}}" placeholder="Sector Name" required>--}}

{{--                                                    @if ($errors->has('name'))--}}
{{--                                                        <span class="help-block">--}}
{{--                                      <strong>{{ $errors->first('name') }}</strong>--}}
{{--                                  </span>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">--}}
{{--                                                <label for="amount" class="col-md-4 control-label">Amount</label>--}}

{{--                                                <div class="col-md-6">--}}
{{--                                                    <input id="amount" type="text" class="form-control" name="amount" value="{{$income->amount}}" placeholder="Amount" required>--}}

{{--                                                    @if ($errors->has('amount'))--}}
{{--                                                        <span class="help-block">--}}
{{--                                      <strong>{{ $errors->first('amount') }}</strong>--}}
{{--                                  </span>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">--}}
{{--                                                <label for="description" class="col-md-4 control-label">Description</label>--}}

{{--                                                <div class="col-md-6">--}}
{{--                              <textarea id="description" class="form-control"--}}
{{--                                        rows="3"--}}
{{--                                        name="description" placeholder="Description" required>{{$income->description}}</textarea>--}}

{{--                                                    @if ($errors->has('description'))--}}
{{--                                                        <span class="help-block">--}}
{{--                                      <strong>{{ $errors->first('description') }}</strong>--}}
{{--                                  </span>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <div class="col-sm-offset-4 col-sm-8">--}}
{{--                                                    <button type="submit" class="btn btn-danger">Save</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    @endisset--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function(){
    // In your Javascript (external .js resource or <script> tag)
    $('#book_title').chosen({
      max_selected_options:10, //Max select limit
      display_selected_options:true,
    });
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
    });
  })
</script>
@endsection
