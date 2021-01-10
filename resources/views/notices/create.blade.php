@extends('layouts.student-app')

@section('title', 'Add Notice')

@section('content')

    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-exclamation-circle"></i>
            Create Notices
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.notices')}}">Inactive
                Notices</a>
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" class="text-color">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Create Notices</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="item-title">
                <h4 class="text-teal fancy4">
                    Create Notice
                </h4>
            </div>
            <div class="col-md-12">
                <form action="{{ route('store.notice') }}" method="POST" class="new-added-form"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label>Title: </label>
                    <div class="form-group">
                        <input type="text" name="title" id="title" placeholder="File title here..." required
                               class="form-control">
                    </div>
                    <div class="form-group mg-t-10">
                        <input type="file" id="filePath" name="file_path">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>: </label>
                        <textarea class="ckeditor form-control" name="description" id="description"
                                  rows="10"></textarea>
                    </div>
                    <button type="submit" class="button button--save float-right">Upload</button>
                </form>
            </div>


            {{--            @component('components.file-uploader',['upload_type'=>'notice', 'section_id' => ''])--}}
            {{--            @endcomponent--}}
            {{--            <br>--}}

        </div>
    </div>

@endsection
@push('customjs')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>

@endpush
