<?php

namespace App\Rules;

use App\Grade;
use App\GradeSystemInfo;
use Illuminate\Contracts\Validation\Rule;

class GreaterThanAll implements Rule
{
    private $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exists = GradeSystemInfo::where('marks_to', '>=',  $value)
            ->where('gradesystem_id', $this->data)
            ->count();
        return !$exists;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Marks Starts From should be greater then others';
    }
}
