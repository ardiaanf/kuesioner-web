<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AnswerWithinRange implements Rule
{
    protected $studentQuestionId;

    public function __construct($studentQuestionId)
    {
        $this->studentQuestionId = $studentQuestionId;
    }

    public function passes($attribute, $value)
    {
        $questionDetails = DB::table('student_questions')
            ->select('min_range', 'max_range')
            ->where('id', $this->studentQuestionId)
            ->first();

        if (!$questionDetails) {
            return false;
        }

        $minRange = $questionDetails->min_range;
        $maxRange = $questionDetails->max_range;

        $answer = intval($value);
        return $answer >= $minRange && $answer <= $maxRange;
    }

    public function message()
    {
        return 'The answer must be within the allowed range based on the student question.';
    }
}
