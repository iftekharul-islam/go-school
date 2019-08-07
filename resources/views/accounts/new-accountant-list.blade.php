@extends('layouts.student-app')

@section('title', 'Accountants')

@section('content')
<div>
    @if(count($users) > 0)
        <div class="">
            @component('components.new-users-list',['users'=>$users])@endcomponent
        </div>
    @else
        <div class="">
            No Related Data Found.
        </div>
    @endif
</div>
@endsection
