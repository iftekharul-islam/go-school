@extends('layouts.student-app')
@section('title', 'Fee Transaction')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Transaction</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Fee Transaction</h3>
                            </div>
                        </div>
                        <div class="mb-5">
                            <form class="new-added-form" action="{{ route('accountant.all-student') }}" method="get">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                        <label>Class</label>
                                        <select name="class" id="class_number" class="select2" onchange="getSections(this)">
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">class - {{ $class->class_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                        <label>Section</label>
                                        <select class="form-control" id="section" name="section" ></select>
                                    </div>
                                    <div class="col-12 form-group mg-t-8 float-right">
                                        <button type="submit" class="button--save button">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">

        function getSections(item) {
            let selectedClass = item.value;
            let classes = {!! json_encode($classes->toArray()) !!};
            let sections = [];
            classes.forEach((cls) => {
                if (cls.id == selectedClass) {
                    sections = cls.sections;
                }
            });

            $('#section').empty();
            sections.forEach((sec) => {
                $('#section').append($("<option />").val(sec.id).text(sec.section_number));
            });
        }
    </script>
@endpush