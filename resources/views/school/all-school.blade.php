@extends('layouts.student-app')
@section('title','All School')
@section('content')
    <div class="breadcrumbs-area">
        <h3>All Schools</h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Schools</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success mb-2">
            {{ session('status') }}
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body-entire">
        <form id="filter" method='GET' action="">
            <div class="row mb-3 mt-3">
                <div class="form-group col-md-4">
                    <input type="text" name="name" value="{{$searchData['name']}}" class="form-control form-control-sm" placeholder="School Name" />
                </div>
                <div class="form-group col-md-3">
                    <select name="district" id="district" class="form-control form-control-sm select2">
                        <option value="">Select District</option> 
                        @if (config('districts.districts'))
                            @foreach ( config('districts.districts') as $district)
                                <option value="{{$district}}"  @if($searchData['district'] == $district) selected @endif >{{ $district }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select id="is_sms_enable" name="is_sms_enable" class="form-control form-control-sm">
                        <option value="" selected>SMS Option</option>
                        <option value="yes" @if($searchData['is_sms_enable'] == 'yes') selected @endif >Enabled</option>
                        <option value="no" @if($searchData['is_sms_enable'] == 'no') selected @endif >Disabled</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="button button--save font-weight-bold">Search</button>
                    <button type="button" onclick="resetFilter()" class="button button--cancel font-weight-bold ml-md-3">Reset</button>
                </div>
            </div>
            </form>
            @if (!$schools->isEmpty() )
                <div class="row">
                    <div class="col-sm-12 school col-md-12 col-lg-12 ">
                        <div class="table-responsive">
                            <table class="table table-bordered display text-wrap">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>School Name</th>
                                    <th>Medium</th>
                                    <th>Students</th>
                                    <th>Departments</th>
                                    <th>District</th>
                                    <th>SMS</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($schools as $school)
                                        <tr>
                                            <td>{{ $school->code }}</td>
                                            <td><a href="{{url('master/school/'.$school->id)}}" class="text-teal"> {{ $school->name }} </a></td>
                                            <td>{{ ucfirst($school->medium) }}</td>
                                            <td>{{ count($school->users->where('role', 'student')) }}</td>
                                            <td>{{ count($school->departments) }}</td>
                                            <td>{{ $school->district }}</td>
                                            <td>
                                               {!! $school->is_sms_enable == 1 ? "<span class=\"badge badge-info\">Enabled</span>" : "<span class=\"badge badge-warning\">Disabled</span>" !!}
                                            </td>
                                            <td>
                                                <a href="{{route('sms.summary',['id' => $school->id])}}" class="button button--save" title="SMS Summary"> <i class="fas fa-sms"></i></a>&nbsp;
                                                <a href="{{ url('master/school/edit', $school->id) }}" class="button button--edit mr-1 mb-1"><i class="far fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-2 col-sm-12">
                        Showing {{ $schools->firstItem() }} to {{ $schools->lastItem() }} of {{ $schools->total() }}
                    </div>
                    <div class="col-md-10 col-sm-12 text-right">
                        <div class="paginate123 float-right">
                            {{ $schools->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else 
                <p class="text-center">No School Found.</p>
            @endif
        </div>
    </div>
@endsection

@push('customjs')
    <script>
    function resetFilter() {
        $('#filter input[name=name]').val('');
        $("#filter select").empty();
        $('#filter').submit();
    }
    </script>
@endpush
