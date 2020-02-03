@extends('layouts.student-app')

@section('title', 'Accountants')

@section('content')
    <div>
        @if(count($users) > 0)
            <div class="">
                @component('components.new-users-list',['users'=>$users, 'classes' => $classes, 'type' => $type])@endcomponent
            </div>
        @else
            <div class="breadcrumbs-area">
                <h3>
                    <i class="fas fa-users mr-2 "></i>All Librarian
                    <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.librarians') }}">Inactive Librarians</a>
                </h3>
                <ul>
                    <li>
                        <a href="{{ URL::previous() }}" class="text-color">Back &nbsp;|</a>
                        <a style="margin-left: 8px;" href="{{ route(Auth::user()->role. '.home') }}">&nbsp;&nbsp;Home</a>
                    </li>
                    <li>All Librarian</li>
                </ul>
            </div>
            <div class="card mt-5 false-height">
                <div class="card-body text-center mt-5">
                    No Related Data Found.
                </div>
            </div>
        @endif
    </div>
@endsection
