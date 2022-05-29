<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


/**
 * @return mixed
 */
function current_user()
{
    return Auth::user();
}

/**
 * @param $date
 * @return string
 */
function new_date_format($date)
{
    return Carbon::createFromFormat('Y-m-d', $date)->format(config('format.default_date'));
}

/**
 * @param $date
 * @return string
 */
function new_time_date_format($date)
{
    return Carbon::parse($date)->format(config('format.default_date'));
}

/**
 * @param $date
 * @return string
 */
function date_with_month_name($date)
{
    return Carbon::parse($date)->format(config('format.date_with_month_name'));
}

/**
 * @return array
 */
function full_year_by_month()
{
    return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
}

/**
 * @return string
 */
function student_code_generate()
{
    return auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
}

/**
 * @return array
 */
function blood_groups()
{
    return ['N/A', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
}

/**
 * @param $name
 * @param $value_starts
 * @param $text
 * @param $total_field
 * @param $badge
 * @return array
 */
function subject_list($name, $value_starts, $text, $total_field, $badge)
{
    $items = [];
    $initial_value = $value_starts - 1;

    for ($i = 1; $i <= $total_field; $i++) {
        $value = $initial_value + $i;
        $items [] = [
            'id' => 'checkbox' . $value,
            'name' => $name,
            'value' => $value,
            'text' => $text . ' ' . $i,
            'class' => $badge,
            'checked' => $i == 1 ? 'checked' : '',
        ];
    }

    return $items;
}

/**
 * @return array
 */
function subjects()
{
    return [
        [
            'id' => 'checkbox4',
            'name' => 'attendance',
            'value' => 4,
            'text' => 'Attendance',
            'class' => 'badge badge-primary',
            'checked' => 'checked',
        ],
        [
            'id' => 'checkbox18',
            'name' => 'few',
            'value' => 18,
            'text' => 'Final Exam Written',
            'class' => 'badge badge-secondary',
            'checked' => '',
        ],
        [
            'id' => 'checkbox19',
            'name' => 'fem',
            'value' => 19,
            'text' => 'Final Exam MCQ',
            'class' => 'badge badge-secondary',
            'checked' => '',
        ],
        [
            'id' => 'checkbox20',
            'name' => 'practical',
            'value' => 20,
            'text' => 'Practical',
            'class' => 'badge badge-warning',
            'checked' => '',
        ],

    ];
}

/**
 * @return array
 */
function marking_subjects()
{
    $quizzes = subject_list('quiz[]', 5, 'Quiz', 5, 'badge badge-primary');
    $assignments = subject_list('assignment[]', 10, 'Assignment', 3, 'badge badge-success');
    $class_tests = subject_list('ct[]', 13, 'Class Test', 5, 'badge badge-info');
    $subjects = subjects();

    return array_merge($quizzes, $assignments, $class_tests, $subjects);

}
function marking_subjects_quiz()
{
    return subject_list('quiz[]', 5, 'Quiz', 5, 'badge badge-primary');
}
function marking_subjects_assignment()
{
    return subject_list('assignment[]', 10, 'Assignment', 3, 'badge badge-success');
}
function marking_subjects_ct()
{
    return subject_list('ct[]', 13, 'Class Test', 5, 'badge badge-info');
}
function marking_subjects_subject()
{
    return subjects();
}


/**
 * @return array
 */
function roles()
{
    return [
        [
            'id' => 1,
            'name' => 'admin',
        ],
        [
            'id' => 2,
            'name' => 'student',
        ],
        [
            'id' => 3,
            'name' => 'teacher',
        ],
        [
            'id' => 4,
            'name' => 'accountant',
        ],
        [
            'id' => 5,
            'name' => 'librarian',
        ],
        [
            'id' => 6,
            'name' => 'guardian',
        ]
    ];
}

/**
 * @param $role
 * @return mixed
 */
function user_role($role)
{
    return user_roles()[$role];
}

/**
 * @return array
 */
function user_roles(){

    return [
        'admin' => 1,
        'student' => 2,
        'teacher' => 3,
        'accountant' => 4,
        'librarian' => 5,
        'guardian' => 6
    ];
}

/**
 * @param $value
 * @return mixed
 */
function roles_value($value)
{
    return array_flip(user_roles())[$value];
}
