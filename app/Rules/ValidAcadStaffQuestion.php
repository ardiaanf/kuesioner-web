<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidAcadStaffQuestion implements Rule
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
        preg_match('/acad_staff_elements\.(\d+)/', $attribute, $matches);
        $index = $matches[1] ?? null;
        if ($index === null) {
            return false;
        }

        $acadstaffElementId = $this->request->acad_staff_questionnaire['acad_staff_elements'][$index]['id'] ?? null;
        if (!$acadstaffElementId) {
            return false;
        }

        return DB::table('acad_staff_questions')->where('id', $value)->where('acad_staff_element_id', $acadstaffElementId)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected education personel question is invalid.';
    }
}
