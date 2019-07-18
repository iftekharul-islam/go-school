<button class="btn btn-primary btn-lg btn-block" id="create-section-btn-class-{{$class->id}}">+ Create a New Section</button>
<br/>
<div class="panel panel-default" id="create-section-btn-panel-class-{{$class->id}}" style="display:none;">
  <div class="panel-body">
  <form class="form-horizontal" action="{{url('admin/school/add-section')}}" method="post">
      {{csrf_field()}}
      <input type="hidden" name="class_id" value="{{$class->id}}"/>
      <div class="form-group false-padding-bottom-form">
        <label for="section_number{{$class->class_number}}" class="col-sm-6 control-label false-padding-bottom">Section Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="section_number{{$class->class_number}}" name="section_number" placeholder="A, B, C, etc..">
        </div>
      </div>
      <div class="form-group false-padding-bottom-form">
        <label for="room_number{{$class->class_number}}" class="col-sm-6 control-label false-padding-bottom">Room Number</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" id="room_number{{$class->class_number}}" name="room_number" placeholder="Room Number">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="button button--save">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $("#create-section-btn-class-{{$class->id}}").click(function(){
    $("#create-section-btn-panel-class-{{$class->id}}").toggle();
  });
</script>
