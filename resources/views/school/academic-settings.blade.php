@extends('layouts.student-app')

@section('title', 'Academic Setting')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-cog fa-fw"></i>
            Academic Settings
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Academic Settings</li>
        </ul>
    </div>

    <div class="card height-auto false-height aesteric">
        <div class="ui-tab-card">
            <div class="card-body">
                <div class="heading-layout1 mg-b-25">
                    <div class="item-title">
                        <h3>Academic Setting</h3>
                    </div>
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
                <div class="border-nav-tab border-0">
                    <ul class="nav nav-tabs" role="tablist" id="tabMenu">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-0" data-toggle="tab" href="#tab1" role="tab"
                               aria-selected="true">Create Department</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="tab-1" data-toggle="tab" href="#tab2" role="tab"
                               aria-selected="false">Manage Classes</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade show border-0 academic-tab" id="tab1"
                             role="tabpanel">
                            <form class="new-added-form"
                                  action="{{url('admin/school/add-department')}}"
                                  method="post">
                                {{csrf_field()}}
                                <div class="false-padding-bottom-form form-group">
                                    <label for="department_name"
                                           class="col-sm-12 control-label false-padding-bottom">Department
                                        Name<label class="text-danger">*</label></label>
                                    <div class="col-sm-12">
                                        <input type="text" required class="form-control"
                                               id="department_name"
                                               name="department_name"
                                               placeholder="English, Math,...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit"
                                                class="button button--save float-left">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade border-0" id="tab2" role="tabpanel">
                            @include('school.new-manage-classes')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('customjs')
    <script>
        $(document).ready(function () {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');
            $('#tabMenu a[href="#{{ old('tabMain') }}"]').tab('show');

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var idx = $(this).index('a[data-toggle="tab"]');
            $('#tab-' + idx).addClass('active');
        });
    </script>
@endpush
