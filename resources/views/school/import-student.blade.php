@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="dashboard-content-one" >
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-user-plus"></i>
                Add Student
            </h3>
            <ul>
                <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Add Student</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form method="POST" id="registerForm" enctype="multipart/form-data" action="{{ route('students.import') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="file"
                                       class="control-label false-padding-bottom">Select excel/csv file<label class="text-danger">*</label></label>
                                <input type="file" name="users" accept=".xlsx,.csv,.xls" required>
                            </div>
                            <div class="col-md-6">
                                <div class=" form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                        <label for="section"
                                               class="control-label false-padding-bottom">Class
                                            and Section<label class="text-danger">*</label></label>

                                        <select id="section" class="form-control"
                                                name="section" required>
                                            @foreach ($studentSections as $section)
                                                <option value="{{$section->id}}">
                                                    Section: {{$section->section_number}}
                                                    Class:
                                                    {{$section->class->class_number}}</option>
                                            @endforeach
                                        </select>
                                        @php
                                            $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5)
                                        @endphp
                                        @if ($errors->has('section'))
                                            <span class="help-block"><strong>{{ $errors->first('section') }}</strong></span>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <button type="submit" id="" class="button float-right mt-3 button--save">
                                    Import from Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customjs')
    <script>
        $(document).ready(function () {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');
            $('#tabMenu a[href="#{{ old('tabMain') }}"]').tab('show');

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var idx = $(this).index('a[data-toggle="tab"]');
            $('#tab-' + idx).addClass('active');
        });

        function enableEmail () {
        }
        $(document).ready(function() {

            $('.student-name').focusout(function() {
                let inputName = $('.student-name').val();
                console.log('hello ', inputName);
                if (inputName) {
                    let names = inputName.split(' ');

                    console.log('names ', names);

                    let code = {!! $code !!};
                    console.log('code', code);

                    let lastName = names[names.length - 1] ? names[names.length - 1] : names[names.length - 2];

                    let username = lastName + code;

                    $('.student-username').val(username.toLowerCase());

                    console.log('lastname ', lastName);
                }
            });

            $('.email-enable-button').click(function(event) {
                event.preventDefault();
                console.log('hello');
                $('.student-username').remove();
                $('.email-visible').html(`<input id="email" type="email" class="form-control student-email"
                           name="email" value="" placeholder="Enter email address"
                           required>`);
                $('.email-enable-button').remove();
            });



        });
    </script>
@endpush
