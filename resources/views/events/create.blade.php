@extends('layouts.student-app')

@section('title', 'Add Event')

@section('content')

    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-exclamation-circle"></i>
            {{ __('text.create_event') }}
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.events')}}">Inactive
                Events</a>
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" class="text-color mr-2">
                    {{ __('text.Back') }} |</a>
                <a  href="{{ url(current_user()->role.'/home') }}" class="text-color">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.create_event') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
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
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="item-title">
                <h4 class="text-teal fancy4">
                    {{ __('text.create_event') }}
                </h4>
            </div>
            <div class="col-md-12">
                <form action="{{ route('store.event') }}" method="POST" class="new-added-form"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label>{{ __('text.title') }}: </label>
                    <div class="form-group">
                        <input type="text" name="title" id="title" placeholder="File title here..." required
                               class="form-control">
                    </div>
                    <label>{{ __('text.Role') }} :</label>
                    <div class="form-group">
                        <select class="form-control select2" multiple
                                name="roles[]">
                            @foreach(roles() as $role)
                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mg-t-10">
                        <input type="file" id="filePath" name="file_path">
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('text.description') }}</label>: </label>
                        <textarea class="ckeditor form-control" name="description" id="description"
                                  rows="10"></textarea>
                    </div>
                    <button type="submit" class="button button--save float-right">{{ __('text.upload') }}</button>
                </form>
            </div>
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
