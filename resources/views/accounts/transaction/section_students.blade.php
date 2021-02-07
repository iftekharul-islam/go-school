@extends('layouts.student-app')
@section('title', 'Collect Fee')
@push('customcss')
    <style>
        .button-alignment {
            display: flex;
        }
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
@endpush
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>{{ __('text.Collect Fee') }}</h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.Collect Fee') }}</li>
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
                    <form class="new-added-form" action="{{ url(current_user()->role.'/fee-collection/section/student') }}" method="get">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6-xxxl col-lg-6 col-6 col-md-6 form-group">
                                <label>{{ __('text.Class') }}</label>
                                <select name="class_id" id="class_number" class="select2" onchange="getSections(this)">
                                    <option>Select Class</option>
                                    @foreach($classes as $item)
                                        <option value="{{ $item->id }}" @if($class_id == $item->id) selected @endif>class-{{ $item->class_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6-xxxl col-lg-6 col-6 col-md-6 form-group">
                                <label>{{ __('text.Section') }}</label>
                                <select class="form-control select2" id="section" name="section" >
                                    @if(!empty($selected_class['sections']))
                                        @foreach($selected_class['sections'] as $section)
                                            <option value="{{ $section->id }}" @if(request('section') == $section->id) selected @endif>{{ $section->section_number }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 form-group mg-t-2 float-right">
                                <button type="submit" class="button--save button float-right">{{ __('text.Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(count($students) > 0)
                <div class="card height-auto">
                    <div class="card-body text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered display text-wrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('text.Code') }}</th>
                                    <th>{{ __('text.Name') }}</th>
                                    <th>{{ __('text.Class') }}</th>
                                    <th>{{ __('text.Section') }}</th>
                                    <th>{{ __('text.gender') }}</th>
                                    <th>{{ __('text.action') }}</th>
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
                                            <div class="button-alignment">
                                                <a href="{{ url(current_user()->role.'/fee-collection/multiple-fee/'.$student->id) }}" class="button--edit button" target="_blank" title="Collect Fee"><i class="fas fa-plus"></i></a>&nbsp;
                                                <a class="button--save button" href="{{ route('student.fee.collections',['id' => $student->id]) }}" title="Fee history"><i class="fas fa-clipboard-list"></i></a>
                                            </div>
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
