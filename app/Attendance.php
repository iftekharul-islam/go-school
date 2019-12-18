<?php

namespace App;

use App\Events\AttendanceCreated;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'section_id', 'exam_id', 'present', 'user_id'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AttendanceCreated::class,
    ];

    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the section record associated with the attendance.
     */
    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    /**
     * Get the exam record associated with the attendance.
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
}
