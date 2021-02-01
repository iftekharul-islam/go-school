@extends('layouts.student-app')

@section('title', 'Child')

@section('content')
    <div class="breadcrumbs-area">
        <ul>
            <h3>{{ __('text.guardians') }}</h3>
            <li>
                <a href="{{ URL::previous() }}">{{ __('text.Back') }}
                    &nbsp;|</a>
                <a href="{{ (auth()->user()->role. '.home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.guardians') }}</li>
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
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    @if($users->isNotEmpty())
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Children</h3>
                            </div>
                        </div>
                                <table class="table table-bordered display text-wrap">
                                    <thead>
                                    <tr>
                                        <th>{{ __('text.Code') }}</th>
                                        <th>{{ __('text.Name') }}</th>
                                        <th>{{ __('text.Class') }}</th>
                                        <th>{{ __('text.Section') }}</th>
                                        <th>{{ __('text.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->student->student_code }}</td>
                                            <td>{{ $user->student->name }}</td>
                                            <td>{{ $user->student->section->class->class_number }}</td>
                                            <td>{{ $user->student->section->section_number }}</td>
                                            <td><a href="{{ route('child.show', $user->student->id) }}" class="btn btn-success"><i class="fas fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-5">
                                    <div class="col-md-3 col-sm-12">
                                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
                                        of {{ $users->total() }}
                                    </div>
                                    <div class="col-md-9 col-sm-12 text-right">
                                        <div class="paginate123 float-right">
                                            {{ $users->appends(request()->query())->links() }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                    @else
                        <p class="text-center">{{ __('text.No Related Data Found') }}</p>
                    @endif
                </div>
        </div>
    </div>
@endsection
