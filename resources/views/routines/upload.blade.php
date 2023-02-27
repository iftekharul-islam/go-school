@extends('layouts.student-app')

@section('title', 'Upload Routine')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fab fa-readme"></i>
            {{ __('text.upload_routine') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.upload_routine') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form class="new-added-form" action="{{ route('store-routine') }}" enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                <div class="row mb-5">
                                    <div class="col-12 col-md-12 col-sm-12 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{ __('text.routine_title') }}</label>
                                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Routine title" required>
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12 col-md-12 col-sm-12 form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                        <label>{{ __('text.Class') }}</label>
                                        <select class="select2"  id="class_number" name="class" onchange="getSections(this)">
                                            <option>Select Class</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">{{$class->class_number}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('class'))
                                            <span class="help-block">
                                      <strong>{{ $errors->first('class') }}</strong>
                                  </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                    <label>{{ __('text.Section') }}</label>
                                    <select class="form-control" required id="section" name="section" ></select>
                                </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-sm-12  form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                                <label for="file">{{ __('text.upload_picture') }}</label>
                                                <br>
                                                <input id="fileupload" type="file"  accept=".xlsx,.xls,.doc,.docx,.ppt,.pptx,.txt,.pdf,image/png,image/jpeg" name="file" required class="form-control-file">
                                                @if ($errors->has('class'))
                                                    <span class="help-block">
                                                      <strong>{{ $errors->first('class') }}</strong>
                                                  </span>
                                                @endif
                                            </div>
                                            <div class="col-6 form-group mg-t-8 mt-4" style="text-align: right">
                                                <a href="{{ URL::previous() }}" class="button button--cancel mr-2" style="margin-left: 1%;" role="button"><b>{{ __('text.Cancel') }}</b></a>
                                                <button id="submit-value" type="submit" disabled class="button routine-button button--save"><b>{{ __('text.save') }}</b></button>
                                            </div>
                                        </div>
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
            if (sections.length > 0 ) {
                $('#submit-value').removeAttr('disabled');
            } else if(sections.length == 0) {
                $('#submit-value').attr('disabled','disabled');
            }
            $('#section').empty();
            sections.forEach((sec) => {
                $('#section').append($("<option />").val(sec.id).text(sec.section_number));
            });
        }
    </script>
@endpush
