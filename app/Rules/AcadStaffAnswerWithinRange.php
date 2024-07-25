<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AcadStaffAnswerWithinRange implements Rule
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
        preg_match('/acad_staff_elements\.(\d+)/', $attribute, $matches);
        $index = $matches[1] ?? null;
        if ($index === null) {
            return false;
        }

        $acadstaffQuestionId = $this->request->input("acad_staff_questionnaire.acad_staff_elements.{$index}.acad_staff_question.id");
        if (!$acadstaffQuestionId) {
            return false;
        }

        $ranges = DB::table('acad_staff_questions')
            ->select('min_range', 'max_range')
            ->where('id', $acadstaffQuestionId)
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
        return 'The answer is not within the allowed range.';
    }
}
