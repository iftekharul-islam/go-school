@extends('layouts.student-app')

@section('title', 'Set RFID')

@section('content')
    

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                Create RFID
            </h3>
            <ul>
                <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Create RFID</li>
            </ul>
        </div>
        <div class="false-height">
            <div class="row">
                <div class="col-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form action="{{ route('rfid.store', $user->student_code) }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="rfid">Student Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="rfid">RFID</label>
                                    <input name="rfid" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="button button--save">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@push('customjs')
    
@endpush

@endsection
