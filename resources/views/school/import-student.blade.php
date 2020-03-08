@extends('layouts.student-app')

@section('title', 'Import Students')

@section('content')
    <div class="dashboard-content-one" >
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-user-plus"></i>
                {{ __('text.Import Student') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.Import Student') }}</li>
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
                    <form method="POST" id="importForm" enctype="multipart/form-data" action="{{ route('students.import') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="file"
                                       class="control-label false-padding-bottom">{{ __('text.select_excel') }}<label class="text-danger">*</label></label>
                                <input id="import-file" type="file" name="users" accept=".xlsx,.csv,.xls" required>
                            </div>
                            <div class="col-md-6">
                                <div class=" form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                        <label for="section"
                                               class="control-label false-padding-bottom">{{ __('text.class_section') }}<label class="text-danger">*</label></label>

                                        <select id="section" class="form-control"
                                                name="section" required>
                                                <option value="" >Select Class with Section</option>
                                            @foreach ($studentSections as $section)
                                                <option class="sec-id" value="{{$section->id}}">
                                                    Class:
                                                    {{$section->class->class_number}}
                                                    Section: {{$section->section_number}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('section'))
                                            <span class="help-block"><strong>{{ $errors->first('section') }}</strong></span>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('download') }}" class="btn button--save mt-3"><i class="fas fa-download"></i> Excel Sample </a>
                                <button type="submit" id="" class="button float-right mt-3 button--save" onclick="confirmImportForm(event)">
                                    {{ __('text.import') }}
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
        function confirmImportForm(e) {

            var section = $( "#section" ).val();
            var import_file = $( "#import-file" ).val();
            if (!section || !import_file){
                return false;
            }
            e.preventDefault();
            let section_details = $("#section").find('option:selected').text();
            swal({
                title: "Are you sure?",
                text: "You have selected to import students for: " + section_details ,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('importForm').submit();
                }
            });
        }
    </script>

@endpush
