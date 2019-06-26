{{--<div class="card">--}}
{{--    <div class="card-title" role="tab" id="heading{{$exam->id}}">--}}
{{--      <a class="card-header collapsed" role="button" data-toggle="collapse" href="#collapse{{$exam->id}}" aria-controls="collapse{{$exam->id}}">--}}
{{--        <h5>--}}
{{--          {{$exam->exam_name}} <span class="pull-right"><small>Click to view all courses under this Exam <i class="material-icons">keyboard_arrow_down</i></small></span>--}}
{{--        </h5>--}}
{{--      </a>--}}
{{--    </div>--}}
{{--    <div id="collapse{{$exam->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$exam->id}}">--}}
{{--      <div class="card-body">--}}
{{--        <table class="table table-bordered table-striped">--}}
{{--            <thead>--}}
{{--                <tr>--}}
{{--                    <th>Class</th>--}}
{{--                    <th>Course Name</th>--}}
{{--                    <th>Course Type</th>--}}
{{--                    <th>Course Time</th>--}}
{{--                    <th>Course Teacher</th>--}}
{{--                </tr>--}}
{{--            </thead>--}}
{{--          <tbody>--}}
{{--            @foreach($courses as $course)--}}
{{--                @if($exam->id == $course->exam_id)--}}
{{--                <tr>--}}
{{--                    <td>{{$course->class->class_number}}</td>--}}
{{--                    <td>{{$course->course_name}}</td>--}}
{{--                    <td>{{$course->course_type}}</td>--}}
{{--                    <td>{{$course->course_time}}</td>--}}
{{--                    <td>--}}
{{--                      <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--          </tbody>--}}
{{--        </table>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}



<div class="card">
    <h3>{{$exam->exam_name}}</h3>
    <div class="card-body">
        <?php $total = 0 ?>
        @foreach($courses as $course)
            @if($exam->id == $course->exam_id)
                @php
                    $total++;
                @endphp
            @endif
        @endforeach
        <p class="float-left">Classes Under exam : {{ $total }}</p>
        <a href="{{ url('/exams/details/'.$exam->id) }}" class="button2 button2--white button2--animation float-right">Classes Under Exam</a>
    </div>
</div>
