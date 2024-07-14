<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Lecturer;
use App\Models\StudentAnswerDetailTlp;
use App\Models\StudentAnswerTlp;
use App\Http\Resources\Admin\LecturerRankingResource;
use App\Models\StudentElement;

class LecturerRankingController extends BaseController
{
    // public function getLecturerRanking()
    // {
    //     $lecturers = Lecturer::select('lecturers.id', 'lecturers.name', 'lecturers.reg_number')
    //         ->join('student_answer_detail_tlps', 'lecturers.id', '=', 'student_answer_detail_tlps.lecturer_id')
    //         ->distinct()
    //         ->get();

    //     $lecturers->map(function ($lecturer) {
    //         $details = StudentAnswerDetailTlp::where('lecturer_id', $lecturer->id)->get();

    //         $averageScore = $details->flatMap(function ($detail) {
    //             return StudentAnswerTlp::where('student_answer_detail_tlp_id', $detail->id)->get();
    //         })->avg('answer');

    //         $lecturer->average_score = $averageScore;
    //     });

    //     return $this->successResponse(LecturerRankingResource::collection($lecturers), 'Lecturer rankings retrieved successfully.');
    // }

    public function getLecturerRanking()
    {
        $lecturers = Lecturer::select('lecturers.id', 'lecturers.name', 'lecturers.reg_number')
            ->join('student_answer_detail_tlps', 'lecturers.id', '=', 'student_answer_detail_tlps.lecturer_id')
            ->distinct()
            ->get();

        $lecturers->map(function ($lecturer) {
            $details = StudentAnswerDetailTlp::where('lecturer_id', $lecturer->id)->get();

            $teoriScores = collect();
            $praktikumScores = collect();

            $details->each(function ($detail) use (&$teoriScores, &$praktikumScores) {
                $answers = StudentAnswerTlp::where('student_answer_detail_tlp_id', $detail->id)->get();
                foreach ($answers as $answer) {
                    $studentElement = StudentElement::where('id', $answer->student_element_id)->first();
                    if ($studentElement->name == 'Teori') {
                        $teoriScores->push($answer->answer);
                    } elseif ($studentElement->name == 'Praktikum') {
                        $praktikumScores->push($answer->answer);
                    }
                }
            });

            $averageTheory = $teoriScores->avg();
            $averagePracticum = $praktikumScores->avg();

            $lecturer->average_theory = $averageTheory;
            $lecturer->average_practicum = $averagePracticum;
        });

        return $this->successResponse(LecturerRankingResource::collection($lecturers), 'Lecturer rankings retrieved successfully.');
    }

    // public function getLecturerRankingByStudyProgramId()
    // {
    //     $studyProgramId = request()->query('study_program_id');

    //     $lecturers = Lecturer::with('studyPrograms')->select('lecturers.id', 'lecturers.name', 'lecturers.reg_number', 'lecturer_study_programs.study_program_id', 'lecturer_study_programs.lecturer_id', 'study_programs.name as study_program_name')
    //         ->join('lecturer_study_programs', 'lecturers.id', '=', 'lecturer_study_programs.lecturer_id')
    //         ->join('study_programs', 'lecturer_study_programs.study_program_id', '=', 'study_programs.id')
    //         ->where('lecturer_study_programs.study_program_id', $studyProgramId)
    //         ->distinct()
    //         ->get();

    //     $lecturers->map(function ($lecturer) {
    //         $details = StudentAnswerDetailTlp::where('lecturer_id', $lecturer->id)->get();

    //         $averageScore = $details->flatMap(function ($detail) {
    //             return StudentAnswerTlp::where('student_answer_detail_tlp_id', $detail->id)->get();
    //         })->avg('answer');

    //         $lecturer->average_score = $averageScore;
    //     });

    //     return $this->successResponse(LecturerRankingResource::collection($lecturers), 'Lecturer rankings retrieved successfully.');
    // }

    public function getLecturerRankingByStudyProgramId()
    {
        $studyProgramId = request()->query('study_program_id');

        $lecturers = Lecturer::with('studyPrograms')->select('lecturers.id', 'lecturers.name', 'lecturers.reg_number', 'lecturer_study_programs.study_program_id', 'lecturer_study_programs.lecturer_id', 'study_programs.name as study_program_name')
            ->join('lecturer_study_programs', 'lecturers.id', '=', 'lecturer_study_programs.lecturer_id')
            ->join('study_programs', 'lecturer_study_programs.study_program_id', '=', 'study_programs.id')
            ->where('lecturer_study_programs.study_program_id', $studyProgramId)
            ->distinct()
            ->get();

        $lecturers->map(function ($lecturer) {
            $details = StudentAnswerDetailTlp::where('lecturer_id', $lecturer->id)->get();

            $teoriScores = collect();
            $praktikumScores = collect();

            $details->each(function ($detail) use (&$teoriScores, &$praktikumScores) {
                $answers = StudentAnswerTlp::where('student_answer_detail_tlp_id', $detail->id)->get();
                foreach ($answers as $answer) {
                    $studentElement = StudentElement::where('id', $answer->student_element_id)->first();
                    if ($studentElement->name == 'Teori') {
                        $teoriScores->push($answer->answer);
                    } elseif ($studentElement->name == 'Praktikum') {
                        $praktikumScores->push($answer->answer);
                    }
                }
            });

            $averageTheory = $teoriScores->avg();
            $averagePracticum = $praktikumScores->avg();

            $lecturer->average_theory = $averageTheory;
            $lecturer->average_practicum = $averagePracticum;
        });

        return $this->successResponse(LecturerRankingResource::collection($lecturers), 'Lecturer rankings retrieved successfully.');
    }
}
