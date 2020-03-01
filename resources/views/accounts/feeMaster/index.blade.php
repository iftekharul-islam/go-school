@extends('layouts.student-app')
@section('title', 'Fee Master')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Fee Master</h3>
            <ul>
                <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Fee Master</li>
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="item-title">
                                <label for="Add Fee Master">Add New Fee Master</label><br>
                                <a href="{{ url(auth()->user()->role.'/fee-master/create') }}" class="button button--save form-group" style="margin-top: 5px;">Add Fee Master</a>
                            </div>
                        </div>
                        <div class="col-md-7 offset-2">
                            <form class="new-added-form" action="{{ url(auth()->user()->role.'/fee-master/class-fee') }}" method="get">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 offset-4 col-lg-6 col-6 form-group">
                                        <label>Class</label>
                                        <select name="class" id="class_number" class="select2">
                                            <option value="0">Select class</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" @if( request()->class == $class->id ) selected @endif>Class - {{ $class->class_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group mt-5">
                                        <button type="submit" class="button--save button" style="margin-top: 5px;">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($feeMasters) && count($feeMasters) > 0)
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h3 class="float-left mb-5">Fee Master</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table display text-wrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Class</th>
                                    <th>Fee Name</th>
                                    <th>Amount</th>
                                    <th>Year</th>
                                    <th>Due Date</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($feeMasters as $feeMaster)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $feeMaster['myclass']['class_number'] }}</td>
                                        <td>{{ @$feeMaster['feeType']['name'] }}</td>
                                        <td>{{ $feeMaster['amount'] }}</td>
                                        <td>{{ now()->year }}</td>
                                        <td>{{ $feeMaster['due'] }}</td>
                                        <td class="text-capitalize">{{ $feeMaster['format'] }}</td>
                                        <td>
                                            <a href="{{ url(auth()->user()->role.'/fee-master/'.$feeMaster->id.'/edit') }}" class="button button--save mr-3"><i class="far fa-edit"></i></a>
                                            <button class="button button--cancel" onclick="feeMaster({{ $feeMaster->id }})"><i class="far fa-trash-alt"></i></button>
                                            <form id="delete-form-{{ $feeMaster->id }}" action="{{ url(auth()->user()->role.'/fee-master',$feeMaster->id) }}" method="POST">
                                                {!! method_field('delete') !!}
                                                {!! csrf_field() !!}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="card height-auto">
                    <div class="card-body text-center">
                        No Fees Found!
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">
        function feeMaster(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                        setTimeout(5000);
                        swal("Done! Your Selected file has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        }
    </script>
@endpush
