@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Manage Academy
        </h3>
        <ul>
            <li><a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Manage Academy</li>
        </ul>
    </div>

    <div class="height-auto false-height">
        <div class="">
            <div class="row">
                <!-- Summery Area Start Here -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-user-graduate text-light"></i>
                                </div>
                            </div>
                            <div class="col-6 col-md-8">
                                <div class="item-content">
                                    <div class="item-title">Total Student</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_students }}">{{ $total_students }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-school text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Classes</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_classes }}">{{ $total_classes }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-chalkboard-teacher	 text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Teacher</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{ $total_teacher }}">{{ $total_teacher }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-teal">
                                    <i class="fas fa-door-open text-light"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Total Departments</div>
                                    <div class="item-number"><span class="counter"
                                                                   data-num="{{count($school->departments)}}">{{count($school->departments)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if(\Auth::user()->role == 'master')
                    <div class="card false-height ml-4" style="width: 98%">
                        <div class="col-12-xxxl col-xl-12">
                            <div class="account-settings-box">
                                <div class="card-body">
                                    <div class="heading-layout1 mg-b-20">
                                        <div class="item-title">
                                            <h3>School Details</h3>
                                            <a href="{{ url('master/school/edit', $school->id) }}" class="button button--edit float-right"><i class="fas fa-edit"></i>&nbsp;Edit School</a>
                                        </div>
                                    </div>
                                    @if($school->logo)
                                    <div class="row">
                                        <div class="col-6">
                                            <img class="details-page-logo" src="{{ asset($school->logo) }}">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="user-details-box">
                                        <div class="item-content">
                                            <div class="info-table table-responsive">
                                                <table class="table text-wrap">
                                                    <tbody>
                                                    <tr>
                                                        <td class="">Name:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Code:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Theme:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->theme }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Established:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->established }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Details:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->about }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Total Admin:</td>
                                                        <td class="font-medium text-dark-medium">{{ $admins->count() }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mt-5">
                                            <a class="button button--save" role="button"
                                               href="{{url('master/register/admin/'.$school->id)}}">
                                                + Create Admin
                                            </a>
                                        </div>
                                        <div class="col-md-4 mt-5">
                                            <a class="button button--save" role="button"
                                               href="{{url('master/school/admin-list/'.$school->id)}}">
                                               View Admins
                                            </a>
                                        </div>
                                        <div class="col-md-4 mt-5">
                                            <button class="button button--cancel" type="button"
                                                    onclick="removeSchool({{ $school->id }})">Delete
                                            </button>
                                            <form id="delete-form-{{ $school->id }}"
                                                  action="{{ url('master/school/delete/'.$school->id) }}" method="GET"
                                                  style="display: none;">
                                                @csrf
                                                @method('GET')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('customjs')
        <script type="text/javascript">
            function removeSchool(id) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        icon: "success";
                        document.getElementById('delete-form-'+id).submit();
                    }
                });
            }
        </script>
    @endpush
@endsection