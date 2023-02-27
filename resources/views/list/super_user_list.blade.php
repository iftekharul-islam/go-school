@extends('layouts.student-app')

@section('title', 'Notices')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-users mr-2 "></i>   {{ __('text.staff_list') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" class="mr-2">
                    {{ __('text.Back') }}</a>|
                <a href="{{ route(current_user()->role . '.home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>
                {{ __('text.staff_list') }}
            </li>
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
    <div class="card height-auto">
        <div class="card-body">
            @if(count($users))
                <div class="mb-5">
                        <table class="table table-bordered table-data-div list display text-wrap">
                            <thead>
                            <tr>
                                <th>{{ __('text.Name') }}</th>
                                <th>{{ __('text.email_username') }}</th>
                                <th>{{ __('text.phone_number') }}</th>
                                <th>{{ __('text.designation') }}</th>
                                <th>{{ __('text.school') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key=>$user)
                                <tr>
                                    <td>
                                        <a class="text-teal" href="{{url('user/'.$user->student_code)}}">{{$user->name}}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->school->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-5">
                            <div class="col-md-9 col-sm-12 text-right">
                                <div class="paginate123 float-right">
                                    {{ $users->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
            @else
                <p class="text-center">{{ __('text.No_related_data_notification') }}</p>
            @endif
        </div>
    </div>
@endsection
