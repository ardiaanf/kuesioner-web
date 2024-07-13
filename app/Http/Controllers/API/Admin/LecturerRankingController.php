<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Lecturer;
use App\Models\StudentAnswerDetailTlp;
use App\Models\StudentAnswerTlp;

class LecturerRankingController extends BaseController
{
    public function index()
    {
        // Retrieve all lecturers that are referenced in StudentAnswerDetailTlp
        $lecturers = Lecturer::select('lecturers.*')
            ->join('student_answer_detail_tlps', 'lecturers.id', '=', 'student_answer_detail_tlps.lecturer_id')
            ->distinct()
            ->get();

        $lecturerRankings = $lecturers->map(function ($lecturer) {
            // For each lecturer, find all associated StudentAnswerDetailTlp records
            $details = StudentAnswerDetailTlp::where('lecturer_id', $lecturer->id)->get();

            // Use the details to find corresponding StudentAnswerTlp entries and calculate the average answer value
            $averageScore = $details->flatMap(function ($detail) {
                return StudentAnswerTlp::where('student_answer_detail_tlp_id', $detail->id)->get();
            })->avg('answer');

            // Return the lecturer with their average score
            return [
                'lecturer_id' => $lecturer->id,
                'lecturer_name' => $lecturer->name,
                'average_score' => $averageScore,
            ];
        });

        // Return the results
        return response()->json($lecturerRankings);
    }
}
