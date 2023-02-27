@extends('layouts.student-app')
@section('title', 'Examination Results')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-alt"></i>
           {{ __('text.upload_result') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.upload_result') }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="card height-auto">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>{{ __('text.Exams') }} {{ __('text.Name') }}: {{ $exam->exam_name }}</h3>
                    <form class="new-added-form" action="{{ route('exams.update.result',['exam_id' => $exam->id]) }}" method="POST" enctype='multipart/form-data'>
                        <input type="hidden" value="{{ $exam->exam_name }}" name="exam_name">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="result_file" class="control-label false-padding-bottom">{{ __('text.select_file') }} (pdf,excel)<label class="text-danger">*</label></label>
                                <input type="file" class="form-control" id="result_file" name="result_file" value="" >
                                 @if ($errors->has('result_file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('result_file') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit"  class="button button--save">{{ __('text.upload') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
  <script type="text/javascript">
    function removeExam(id) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
              .then((willDelete) => {
                if (willDelete) {
                  document.getElementById('delete-form-'+id).submit();
                }
              });
    }
  </script>
@endpush
