@extends('layouts.student-app')

@section('title', 'Teachers')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="main-container">
            <div class="panel panel-default">
              @if(count($users) > 0)
                <div class="panel-body">
                    @component('components.new-users-list',['users'=>$users,'current_page'=>$current_page,'per_page'=>$per_page])
                    @endcomponent
                </div>
              @else
                <div class="panel-body">
                    No Related Data Found.
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection
