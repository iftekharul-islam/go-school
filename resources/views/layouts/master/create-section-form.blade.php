<button class="btn btn-info btn-lg mt-5 mb-4" id="create-section-btn-class-{{$class->id}}">+ Create a New Section
</button>
<button class="btn btn-lg btn-primary ml-3 btn-lg mt-5 mb-4" id="edit-class-info-{{$class->id}}"><i class="far fa-edit"></i> Edit Class Info</button>
<br/>
<div class="panel panel-default" id="create-section-btn-panel-class-{{$class->id}}" style="display:none;">
    <div class="panel-body">
        <form class="form-horizontal" action="{{url('admin/school/add-section')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="class_id" value="{{$class->id}}"/>
            <div class="form-group false-padding-bottom-form">
                <label for="section_number{{$class->class_number}}" class="col-sm-6 control-label false-padding-bottom">Section
                    Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="section_number{{$class->class_number}}"
                           name="section_number" placeholder="A, B, C, etc..">
                </div>
            </div>
            <div class="form-group false-padding-bottom-form">
                <label for="room_number{{$class->class_number}}" class="col-sm-6 control-label false-padding-bottom">Room
                    Number</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="room_number{{$class->class_number}}"
                           name="room_number" placeholder="Room Number">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="button button--save float-right">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="panel panel-default" id="edit-class-info-panel-{{$class->id}}" style="display: none;">
    <div class="panel-body">
        <form class="form-horizontal" action="{{ route('update-class-info', $class->id) }}" method="post">
            {{csrf_field()}}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label for="classNumber{{$school->id}}" class="col-sm-12 control-label">Class Number/Name</label>
                <div class="col-sm-12">
                    <input type="text" name="class_number" class="form-control" id="classNumber{{$school->id}}" value="{{ $class->class_number }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="classRoomNumber{{$school->id}}" class="col-md-12 control-label">Class Group (If Any)</label>
                <div class="col-sm-12">
                    <select class="form-control" name="group" id="classRoomNumber{{$school->id}}">
                        <option value="">None</option>
                        <option value="Science">Science</option>
                        <option value="Arts">Arts</option>
                        <option value="Commerce">Commerce</option>
                    </select>
                    <span id="helpBlock" class="help-block">Select none if this Class belongs to no Group</span>
                </div>
            </div>

            <div class="form-group">
                <label for="classWithDepartment{{$school->id}}" class="col-md-12 control-label">Department</label>
                <div class="col-sm-12">
                    <select class="form-control" name="department" id="classWithDepartment">
                        <option value="" selected>None</option>
                        @if($adminAccessDepartment->count() > 0)
                            @foreach($adminAccessDepartment as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        @else
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <span id="helpBlock" class="help-block">Select none if this Class belongs to no Department</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="button button--save float-right">Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>


@push('customjs')
    <script>
        $("#create-section-btn-class-{{$class->id}}").click(function () {
            $("#create-section-btn-panel-class-{{$class->id}}").toggle();
        });

        $("#edit-class-info-{{$class->id}}").click(function () {
            $("#edit-class-info-panel-{{$class->id}}").toggle();
        });
    </script>
@endpush
