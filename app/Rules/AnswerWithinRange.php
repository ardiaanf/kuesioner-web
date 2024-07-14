<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class AnswerWithinRange implements Rule
{
    protected $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        preg_match('/student_elements\.(\d+)/', $attribute, $matches);
        $index = $matches[1] ?? null;
        if ($index === null) {
            return false;
        }

        $studentQuestionId = $this->request->student_questionnaire['student_elements'][$index]['student_question']['id'] ?? null;
        if (!$studentQuestionId) {
            return false;
        }

        $ranges = DB::table('student_questions')
            ->select('min_range', 'max_range')
            ->where('id', $studentQuestionId)
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
        return "The answer is not within the allowed range.";
    }
}
