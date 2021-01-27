@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Manage Academy
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li><a href="{{ route('all.school') }}">All School</a></li>
            <li>Manage Academy</li>
        </ul>
    </div>

    <div class="height-auto false-height">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
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
                @if(\Auth::user()->role == 'master')
                    <div class="card false-height ml-4" style="width: 98%">
                        <div class="col-12-xxxl col-xl-12">
                            <div class="account-settings-box">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 heading-layout1 ">
                                            <div class="item-title">
                                                <h3 class="item-title">School Details</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right ">
                                            <a class="button button--save mr-1 mb-1" role="button"
                                               href="{{url('master/register/admin/'.$school->id)}}">
                                                <i class="fas fa-plus"></i> Create Admin
                                            </a>

                                            <a class="button button--save mr-1 mb-1" role="button"
                                               href="{{url('master/school/admin-list/'.$school->id)}}">
                                                <i class="fas fa-eye"></i> View Admins
                                            </a>

                                            <a href="{{ url('master/school/edit', $school->id) }}"
                                               class="button button--edit mr-1 mb-1"><i class="fas fa-edit"></i>&nbsp;Edit
                                                School</a>

                                            @php
                                                $status = $school->is_active == 0 ? 1 : 0;
                                                $btnIcon = $school->is_active == 0 ? 'fas fa-check-circle' : 'fas fa-ban';
                                                $btnText = $school->is_active == 0 ? 'Activate' : 'Deactivate';
                                            @endphp

                                            <a href="{{ route('school.status.update', ['school_id' => $school->id, 'status' => $status]) }}"
                                               class="button button--cancel mr-1 mb-1"><i class="{{ $btnIcon }}"></i>&nbsp; {{ $btnText }}
                                            </a>

                                            <button type="button" class="button button--cancel mb-1" data-toggle="modal"
                                                    data-target="#confirmPassword"><i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            @if ( $school->logo )
                                                <img class="details-page-logo" src="{{ asset($school->logo) }}">
                                            @endif
                                            <div class="table-responsive">
                                                <table class="table text-wrap table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td width="30%" class="">Name:</td>
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
                                                        <td class="">District:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->district }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Address:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->school_address }}</td>
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
                                        <div class="col-md-6 col-sm-12">
                                            <div class="table-responsive item-title">
                                                <caption><h3 class="">Configuration</h3></caption>
                                                <table class="table text-wrap table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td width="30%" class="">SMS:</td>
                                                        <td class="font-medium text-dark-medium">
                                                            @if($school->is_sms_enable == 1)
                                                                <span class="badge badge-info"><i
                                                                        class="fa fa-check"></i> Enabled</span>
                                                            @else
                                                                <span class="badge badge-warning"><i
                                                                        class="fa fa-ban"></i> Disabled</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%" class="">Onilne SMS:</td>
                                                        <td class="font-medium text-dark-medium">
                                                            @if($school->online_class_sms == true)
                                                                <span class="badge badge-info"><i
                                                                        class="fa fa-check"></i> Enabled</span>
                                                            @else
                                                                <span class="badge badge-warning"><i
                                                                        class="fa fa-ban"></i> Disabled</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Per SMS:</td>
                                                        <td class="font-medium text-dark-medium">@empty($school->sms_charge)
                                                                0.00 @else {{ $school->sms_charge }} @endempty</td>
                                                    </tr>
                                                    @if($school->payment_type == 'monthly')
                                                        <tr>
                                                            <td class="">Payment Type:</td>
                                                            <td class="font-medium text-dark-medium">{{ ucfirst($school->payment_type) }}</td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td class="">@if($school->payment_type == 'monthly')
                                                                Charge @else Per Student Charge @endif:
                                                        </td>
                                                        <td class="font-medium text-dark-medium">{{ $school->charge }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="">E-Mail:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Inv. Gen. Date:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->invoice_generation_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Sign Up Date:</td>
                                                        <td class="font-medium text-dark-medium">@if($school->singup_date) {{ date('d F Y', strtotime($school->singup_date)) }}@endif </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Pay. Due Date:</td>
                                                        <td class="font-medium text-dark-medium">{{ $school->due_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">School:</td>
                                                        <td class="font-medium text-dark-medium">
                                                            @if ($school->is_active == 1)
                                                                <span class="badge badge-info"><i
                                                                        class="fa fa-check"></i> Active</span>
                                                            @else
                                                                <span class="badge badge-warning"><i
                                                                        class="fa fa-ban"></i> Inactive</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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

    <div class="modal fade" id="confirmPassword" role="dialog" aria-labelledby="confirmPassword">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Confirm Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="new-added-form" action="{{ route('school.delete',['school_id' => $school->id]) }}"
                      method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password" class="col-sm-12 control-label">Enter Password</label>
                            <div class="col-sm-12">
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group modal-footer pb-">
                        <div class="col-md-12">
                            <button type="submit" class="button button--save float-right">Confirm</button>
                        </div>
                    </div>
                </form>
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
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
            }
        </script>
    @endpush
@endsection
