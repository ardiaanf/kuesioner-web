<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidLecturerQuestion implements Rule
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

        $lecturerElementId = $this->request->lecturer_questionnaire['lecturer_elements'][$index]['id'] ?? null;
        if (!$lecturerElementId) {
            return false;
        }

        return DB::table('lecturer_questions')->where('id', $value)->where('lecturer_element_id', $lecturerElementId)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected lecturer question is invalid.';
    }
}
