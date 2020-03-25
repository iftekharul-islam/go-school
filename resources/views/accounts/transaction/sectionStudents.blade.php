@extends('layouts.student-app')
@section('title', 'Collect Fee')
@section('content')
    <style type="text/css">
        .example-print {
            display: none;
        }
        @media print {
            .example-screen {
                display: none;
            }
            .example-print {
                margin: 10mm 0 0 0;
                display: block;
            }
            .report {
                margin-bottom: 20px;
            }
            table tbody .grand-total td {
                background-color: #DCDCDC !important;
            }
            tbody td .month {
                background-color: #42A746 !important;
            }
            tbody td .month b {
                color: white !important;
            }
            tbody td .paid {
                color: white !important;
                background-color: #287C71 !important;
            }
            tbody td .partial {
                background-color: #FEC23E !important;
            }
            tbody td .unpaid {
                color: white !important;
                background-color: #DC3C45 !important;
            }
        }
    </style>
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Collect Fee</h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Collect Fee</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="new-added-form" action="{{ url(auth()->user()->role.'/fee-collection/section/student') }}" method="get">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                <label>Class</label>
                                <select name="class" id="class_number" class="select2" onchange="getSections(this)">
                                    <option>Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" @if(request('class') == $class->id) selected @endif>class - {{ $class->class_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                <label>Section</label>
                                <select class="form-control" id="section" name="section" >
                                    @if(!empty(request('class')))
                                        @php
                                          $selectedClass = $classes->first( function( $item ) { return $item->id == request('class'); } );
                                        @endphp
                                        @if(!empty($selectedClass['sections']))
                                            @foreach($selectedClass['sections'] as $section)
                                                <option value="{{ $section->id }}" @if(request('section') == $section->id) selected @endif>{{ $section->section_number }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
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
                    <div class="card-body text-center">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>All Students</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table-paginate table-bordered display text-wrap">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $student->student_code }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->section->class->class_number }}</td>
                                        <td>{{ $student->section->section_number }}</td>
                                        <td class="text-capitalize">{{ $student->gender }}</td>
                                        <td>
                                            <a href="{{ url(Auth::user()->role.'/fee-collection/multiple-fee/'.$student->id) }}" class="button--edit button" target="_blank" title="Collect Fee"><i class="fas fa-plus"></i></a>&nbsp;
                                            <a class="button--save button" href="{{ route('student.fee.collections',['id' => $student->id]) }}" title="Fee history"><i class="fas fa-clipboard-list"></i></a>
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
@endpush
