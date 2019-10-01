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
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="new-added-form" action="{{ url(auth()->user()->role.'/fee-collection/section/student') }}" method="get">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                <label>Class</label>
                                <select name="class" id="class_number" class="select2" onchange="getSections(this)">
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">class - {{ $class->class_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                <label>Section</label>
                                <select class="form-control" id="section" name="section" ></select>
                            </div>
                            <div class="col-12 form-group mg-t-2 float-right">
                                <button type="submit" class="button--save button float-right">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(count($students) > 0)
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>All Students</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $student->section->class->class_number }}</td>
                                        <td>{{ $student->section->section_number }}</td>
                                        <td>{{ $student->code }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>
                                            <a class="button--save button" href="{{ url(auth()->user()->role.'/fee-collection/get-fee',$student->id) }}">Collect</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
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