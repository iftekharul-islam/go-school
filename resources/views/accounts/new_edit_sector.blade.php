@extends('layouts.student-app')
@section('title', 'Edit Sector')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i> {{ __('text.edit_sector') }}</h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}">
                    {{ __('text.Back') }}
                </a>
            </li>
            <li>
                <a href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.edit_sector') }}r</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-8">
        <div class="false-height">
            <div class="card">
                <div class="card-body">
                    @isset($sector)
                        <form class="new-added-form justify-content-md-center"
                              action="{{url(current_user()->role.'/update-sector')}}"
                              method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$sector->id}}">
                            <div class="form-group">
                                <label for="name" class="control-label mt-5">{{ __('text.Name') }}<label
                                        class="text-danger">*</label></label>

                                <input id="name" type="text" class="form-control" name="name" value="{{$sector->name}}"
                                       placeholder="Sector Name" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('name') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-4 control-label">{{ __('text.type') }}<label
                                        class="text-danger">*</label></label>
                                <select class="form-control" name="type">
                                    <option value="expense" @if($sector->type == 'expense') selected @endif >Expense
                                    </option>
                                    <option value="income" @if($sector->type == 'income') selected @endif >Income
                                    </option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('type') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="form-group mg-t-8 mb-5">
                                <button type="submit" class="button button--save">{{ __('text.Update') }}</button>
                            </div>
                        </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
