@extends('layouts.student-app')

@section('title', 'Admit card')

@section('content')
    <div class="breadcrumbs-area example-screen">
        <h3>
            <i class="fas fa-file-pdf"></i>
           Admit card
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Admit card</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto">
        <div class="example-screen">
            <div class="card-body">
                <form method="post" action="{{ route('generate.admit') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-4">
                           <select name="class_id" id="inputClass" class="select2" onchange="getSections(this)" required>
                                <option>Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="select2" id="section" name="section" required>
                                <option>Select section</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="button button--save font-weight-bold mt-md-2">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script>
        function getSections(item) {
            let selectedClass = item.value;
            let classes = {!! json_encode($classes->toArray()) !!};
            let sections = [];
            let us = [];
           
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
