<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class LecturerAnswerWithinRange implements Rule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
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
        preg_match('/lecturer_elements\.(\d+)/', $attribute, $matches);
        $index = $matches[1] ?? null;
        if ($index === null) {
            return false;
        }

        $lecturerQuestionId = $this->request->input("lecturer_questionnaire.lecturer_elements.{$index}.lecturer_question.id");
        if (!$lecturerQuestionId) {
            return false;
        }

        $ranges = DB::table('lecturer_questions')
            ->select('min_range', 'max_range')
            ->where('id', $lecturerQuestionId)
            ->first();

        if (!$ranges) {
            return false;
        }

        return $value >= $ranges->min_range && $value <= $ranges->max_range;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
