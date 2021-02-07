@extends('layouts.student-app')
@section('title', 'Account Sectors')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i>
            {{ __('text.add_account_sector') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.add_account_sector') }}</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <form class="new-added-form mb-5" action="{{url(current_user()->role.'/create-sector')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">{{ __('text.sector_name') }}<label class="text-danger">*</label></label>

                                <div class="">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ (!empty($sector->name))?$sector->name:old('name') }}" placeholder="Sector Name" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="type">{{ __('text.sector_type') }}<label class="text-danger">*</label></label>

                                <div class="">
                                    <select  class="select2" name="type">
                                        <option value="expense">Expense</option>
                                        <option value="income">Income</option>
                                    </select>

                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mg-t-8">
                            <button type="submit" class="button button--save ml-4 mt-4">{{ __('text.save') }}</button>
                        </div>
                    </div>
                </form>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="height-auto">
                        <div class="">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>{{ __('text.account_sector') }}</h3>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('text.sector_name') }}</th>
                                    <th>{{ __('text.type') }}</th>
                                    <th>{{ __('text.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($sectors as $index=>$sector)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{$sector->name}}</td>
                                        <td>{{ucfirst($sector->type)}}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{url('accountant/edit-sector/'.$sector->id)}}" class="button button--edit mr-3" role="button"><b><i class="far fa-edit"></i></b></a>
                                                <button class="button button--cancel" onclick="sector({{ $sector->id }})"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                            <form id="delete-form-{{ $sector->id }}" action="{{url(current_user()->role.'/delete-sector/'.$sector->id)}}" method="POST">
                                                {!! method_field('delete') !!}
                                                {!! csrf_field() !!}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script type="text/javascript">
        function sector(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('delete-form-'+id).submit();
                    setTimeout(5000);
                    swal("Done! Your Selected file has been deleted!", {
                        icon: "success",
                    });
                }
            });
        }
    </script>
@endpush
