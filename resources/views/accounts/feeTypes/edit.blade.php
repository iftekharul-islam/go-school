@extends('layouts.student-app')
@section('title', 'Edit Fee Types')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>{{ __('text.Fee Types') }} {{ __('text.edit') }}</h3>
            <ul>
                <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                        {{ __('text.Back') }}</a>|
                    <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.Fee Types') }} {{ __('text.edit') }}</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>{{ __('text.Fee Types') }} {{ __('text.edit') }}</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="@if(auth()->user()->role == 'master') {{ route('update.fee.type',['id' => $feeType->id])}} @else {{ url(auth()->user()->role.'/fee-types', $feeType->id) }} @endif" method="POST">
                            {{ csrf_field() }}
                            {!! method_field('patch') !!}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">{{ __('text.Name') }}</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ $feeType->name }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">{{ __('text.order_no') }}</label>
                                    <input type="number" class="form-control" name="order" value="{{ $feeType->order }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">{{ __('text.Code') }}</label>
                                    <input type="text" placeholder="Code" class="form-control" name="code" value="{{ $feeType->code }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">{{ __('text.description') }}</label>
                                    <textarea class="form-control" placeholder="Description" name="desc">{{ $feeType->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" class="button button--save">{{ __('text.Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
