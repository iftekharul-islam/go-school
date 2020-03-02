<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addClassModal{{$school->id}}">+Add
    New Class
</button>

<!-- Modal -->
<div class="modal fade" id="addClassModal{{$school->id}}" tabindex="-1" role="dialog"
     aria-labelledby="addClassModal{{$school->id}}Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add New Class</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="new-added-form" action="{{url('admin/school/add-class')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="classNumber{{$school->id}}" class="col-sm-12 control-label">Class
                            Number/Name</label>
                        <div class="col-sm-12">
                            <input type="number" name="class_number" class="form-control" id="classNumber{{$school->id}}"
                                   placeholder="Class Number/Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="classRoomNumber{{$school->id}}" class="col-md-12 control-label">Class Group (If
                            Any)</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="group" id="classRoomNumber{{$school->id}}">
                                <option value="">None</option>
                                <option value="Science">Science</option>
                                <option value="Humanities">Humanities</option>
                                <option value="Business Studies">Business Studies</option>
                            </select>
                            {{--              <input type="text" class="form-control" name="group" id="classRoomNumber{{$school->id}}" placeholder="Science, Commerce, Arts, etc.">--}}
                            <span id="helpBlock" class="help-block">Select none if this Class belongs to no Group</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="classWithDepartment{{$school->id}}"
                               class="col-md-12 control-label">Department</label>
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
    </div>
</div>
