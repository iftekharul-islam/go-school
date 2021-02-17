@extends('layouts.student-app')
@section('title', 'Edit Discounts')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>{{ __('text.Discount') }} {{ __('text.edit') }}</h3>
            <ul>
                <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                        {{ __('text.Back') }}</a>|
                    <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.Discount') }} {{ __('text.edit') }}</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>{{ __('text.Discount') }} {{ __('text.edit') }}</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{ url(auth()->user()->role.'/fee-discount', $discount->id) }}" method="post">
                            {{ csrf_field() }}
                            {!! method_field('patch') !!}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">{{ __('text.Name') }}</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ $discount->name }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">{{ __('text.Code') }}</label>
                                    <input type="text" placeholder="Code" class="form-control" name="code" value="{{ $discount->code }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">{{ __('text.amount') }}</label>
                                    <input type="number" step="0.01" placeholder="Code" class="form-control" name="amount" value="{{ $discount->amount }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">{{ __('text.description') }}</label>
                                    <textarea class="form-control" placeholder="Description" name="desc">{{ $discount->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" class="button button--save">{{ __('text.description') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
