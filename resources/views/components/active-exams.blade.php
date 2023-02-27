
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
        <a href="{{ url('/exams/details/'.$exam->id) }}" class="button button--text float-right">Classes Under Exam</a>
    </div>
</div>
