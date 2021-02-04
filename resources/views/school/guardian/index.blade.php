@extends('layouts.student-app')

@section('title', 'Guardian List')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                        <div class="breadcrumbs-area">
                            <ul>
                                <h3>{{ __('text.guardians') }}</h3>
                                <li>
                                    <a href="{{ URL::previous() }}">{{ __('text.Back') }} &nbsp;|</a>
                                    <a href="{{ route( current_user()->role. '.home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                                </li>
                                <li>{{ __('text.guardians') }}</li>
                                <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('create.guardian') }}">{{ __('text.add_guardian') }}</a>
                            </ul>
                        </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @elseif(session('error-status'))
                        <div class="alert alert-success">
                            {{ session('error-status') }}
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
                    <div class="card height-auto">
                        <div class="card-body">
                            @if(count($users) > 0)
                                <form id="userBulkAction" action="{{ route('user.bulk.action') }}" method="post"> {{ csrf_field() }}
                                    <div class="mb-5">
                                        <table class="table table-bordered display text-wrap">
                                            <thead>
                                            <tr>
                                                <th>{{ __('text.Code') }}</th>
                                                <th>{{ __('text.Name') }}</th>
                                                <th>{{ __('text.Email') }}</th>
                                                <th>{{ __('text.phone_number') }}</th>
                                                <th>{{ __('text.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $user->student_code }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_number }}</td>
                                                    <td><a class="btn btn-lg btn-primary mr-3"
                                                           href="{{ route('edit.guardian' , $user->id) }}" title="Update"><i
                                                                class="far fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row mt-5">
                                            <div class="col-md-3 col-sm-12">
                                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                                            </div>
                                            <div class="col-md-9 col-sm-12 text-right">
                                                <div class="paginate123 float-right">
                                                    {{ $users->appends(request()->query())->links() }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            @else
                                <p class="text-center">{{ __('text.No_related_data_notification') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
