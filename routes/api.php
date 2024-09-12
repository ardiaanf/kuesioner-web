<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{
    Auth\AdminAuthController,
    Auth\LecturerAuthController,
    Auth\AcadStaffAuthController,
    Auth\StudentAuthController,
    Admin\StudentQuestionnaireController as AdminStudentQuestionnaireController,
    Admin\StudentElementController as AdminStudentElementController,
    Admin\StudentQuestionController as AdminStudentQuestionController,
    Admin\LecturerQuestionnaireController as AdminLecturerQuestionnaireController,
    Admin\LecturerQuestionController as AdminLecturerQuestionController,
    Admin\LecturerElementController as AdminLecturerElementController,
    Admin\AcadStaffQuestionnaireController as AdminAcadStaffQuestionnaireController,
    Admin\AcadstaffElementController as AdminAcadStaffElementController,
    Admin\AcadStaffQuestionController as AdminAcadStaffQuestionController,
    Admin\AdminController as AccountAdminController,
    Admin\LecturerController as AccountLecturerController,
    Admin\AcadStaffController as AccountAcadStaffController,
    Admin\StudentController as AccountStudentController,
    Admin\LecturerRankingController,
    Admin\MajorController as AdminStudentMajorController,
    Admin\StudentClassController as AdminStudentClassController,
    Admin\StudyProgramController as AdminStudyProgramController,
    Student\StudentQuestionnaireController,
    Student\StudyProgramController as StudentStudyProgramController,
    Student\MajorController as StudentMajorController,
    Student\ClassController as StudentClassController,
    Student\CourseController as StudentCourseController,
    Student\LecturerGetController as StudentLecturerGetController,
    Dosen\LecturerQuestionnaireController as LecturerLecturerQuestionnaireController,
    Tendik\AcadStaffQuestionnaireController as AcadStaffsQuestionnaireController
};
use App\Http\Controllers\API\Student\MajorController;

Route::post('auth/admin', [AdminAuthController::class, 'signin']);
Route::post('auth/lecturer', [LecturerAuthController::class, 'signin']);
Route::post('auth/acadstaff', [AcadStaffAuthController::class, 'signin']);
Route::post('auth/student', [StudentAuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    /**
     * ROUTES FOR ADMIN
     */
    // Student Questionnaires
    Route::get('admin/student-questionnaires', [AdminStudentQuestionnaireController::class, 'index']);
    Route::post('admin/student-questionnaires', [AdminStudentQuestionnaireController::class, 'store']);
    Route::get('admin/student-questionnaires/{studentQuestionnaire}', [AdminStudentQuestionnaireController::class, 'show']);
    Route::get('admin/student-questionnaires/{studentQuestionnaire}/relations', [AdminStudentQuestionnaireController::class, 'showWithRelations']);
    Route::put('admin/student-questionnaires/{studentQuestionnaire}', [AdminStudentQuestionnaireController::class, 'update']);
    Route::delete('admin/student-questionnaires/{studentQuestionnaire}', [AdminStudentQuestionnaireController::class, 'destroy']);

    Route::get('admin/filled-student-questionnaires', [AdminStudentQuestionnaireController::class, 'getFilledQuestionnaires']);

    // Student Elements
    Route::get('admin/student-elements', [AdminStudentElementController::class, 'index']);
    Route::post('admin/student-elements', [AdminStudentElementController::class, 'store']);
    Route::get('admin/student-elements/{studentElement}', [AdminStudentElementController::class, 'show']);
    Route::get('admin/student-elements/{studentElement}/relations', [AdminStudentElementController::class, 'showWithRelations']);
    Route::put('admin/student-elements/{studentElement}', [AdminStudentElementController::class, 'update']);
    Route::delete('admin/student-elements/{studentElement}', [AdminStudentElementController::class, 'destroy']);

    // Student Questions
    Route::get('admin/student-questions', [AdminStudentQuestionController::class, 'index']);
    Route::post('admin/student-questions', [AdminStudentQuestionController::class, 'store']);
    Route::get('admin/student-questions/{studentQuestion}', [AdminStudentQuestionController::class, 'show']);
    Route::put('admin/student-questions/{studentQuestion}', [AdminStudentQuestionController::class, 'update']);
    Route::delete('admin/student-questions/{studentQuestion}', [AdminStudentQuestionController::class, 'destroy']);

    // Lecturer Questionnaire
    Route::get('admin/lecturer-questionnaires', [AdminLecturerQuestionnaireController::class, 'index']);
    Route::post('admin/lecturer-questionnaires', [AdminLecturerQuestionnaireController::class, 'store']);
    Route::get('admin/lecturer-questionnaires/{lecturerQuestionnaire}', [AdminLecturerQuestionnaireController::class, 'show']);
    Route::get('admin/lecturer-questionnaires/{lecturerQuestionnaire}/relations', [AdminLecturerQuestionnaireController::class, 'showWithRelations']);
    Route::put('admin/lecturer-questionnaires/{lecturerQuestionnaire}', [AdminLecturerQuestionnaireController::class, 'update']);
    Route::delete('admin/lecturer-questionnaires/{lecturerQuestionnaire}', [AdminLecturerQuestionnaireController::class, 'destroy']);

    Route::get('admin/filled-lecturer-questionnaires', [AdminLecturerQuestionnaireController::class, 'getFilledQuestionnaires']);

    // Lecturer Elements
    Route::get('admin/lecturer-elements', [AdminLecturerElementController::class, 'index']);
    Route::post('admin/lecturer-elements', [AdminLecturerElementController::class, 'store']);
    Route::get('admin/lecturer-elements/{lecturerElement}', [AdminLecturerElementController::class, 'show']);
    Route::get('admin/lecturer-elements/{lecturerElement}/relations', [AdminLecturerElementController::class, 'showWithRelations']);
    Route::put('admin/lecturer-elements/{lecturerElement}', [AdminLecturerElementController::class, 'update']);
    Route::delete('admin/lecturer-elements/{lecturerElement}', [AdminLecturerElementController::class, 'destroy']);

    // Lecturer Question
    Route::get('admin/lecturer-questions', [AdminLecturerQuestionController::class, 'index']);
    Route::post('admin/lecturer-questions', [AdminLecturerQuestionController::class, 'store']);
    Route::get('admin/lecturer-questions/{lecturerQuestion}', [AdminLecturerQuestionController::class, 'show']);
    Route::put('admin/lecturer-questions/{lecturerQuestion}', [AdminLecturerQuestionController::class, 'update']);
    Route::delete('admin/lecturer-questions/{lecturerQuestion}', [AdminLecturerQuestionController::class, 'destroy']);

    // Academic staff Questionnaire
    Route::get('admin/acadstaff-questionnaires', [AdminAcadStaffQuestionnaireController::class, 'index']);
    Route::post('admin/acadstaff-questionnaires', [AdminAcadStaffQuestionnaireController::class, 'store']);
    Route::get('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}', [AdminAcadStaffQuestionnaireController::class, 'show']);
    Route::get('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}/relations', [AdminAcadStaffQuestionnaireController::class, 'showWithRelations']);
    Route::put('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}', [AdminAcadStaffQuestionnaireController::class, 'update']);
    Route::delete('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}', [AdminAcadStaffQuestionnaireController::class, 'destroy']);

    Route::get('admin/filled-acadstaff-questionnaires', [AdminAcadStaffQuestionnaireController::class, 'getFilledQuestionnaires']);

    // Academic staff Elements
    Route::get('admin/acadstaff-elements', [AdminAcadStaffElementController::class, 'index']);
    Route::post('admin/acadstaff-elements', [AdminAcadStaffElementController::class, 'store']);
    Route::get('admin/acadstaff-elements/{acadstaffElement}', [AdminAcadStaffElementController::class, 'show']);
    Route::get('admin/acadstaff-elements/{acadstaffElement}/relations', [AdminAcadStaffElementController::class, 'showWithRelations']);
    Route::put('admin/acadstaff-elements/{acadstaffElement}', [AdminAcadStaffElementController::class, 'update']);
    Route::delete('admin/acadstaff-elements/{acadstaffElement}', [AdminAcadStaffElementController::class, 'destroy']);

    // Academic staff Question
    Route::get('admin/acadstaff-questions', [AdminAcadStaffQuestionController::class, 'index']);
    Route::post('admin/acadstaff-questions', [AdminAcadStaffQuestionController::class, 'store']);
    Route::get('admin/acadstaff-questions/{acadstaffQuestion}', [AdminAcadStaffQuestionController::class, 'show']);
    Route::put('admin/acadstaff-questions/{acadstaffQuestion}', [AdminAcadStaffQuestionController::class, 'update']);
    Route::delete('admin/acadstaff-questions/{acadstaffQuestion}', [AdminAcadStaffQuestionController::class, 'destroy']);

    Route::middleware('role:admin')->group(function () {
        // Account Management Admin
        Route::get('admin/admins', [AccountAdminController::class, 'index']);
        Route::post('admin/admins', [AccountAdminController::class, 'store']);
        Route::get('admin/admins/{admin}', [AccountAdminController::class, 'show']);
        Route::put('admin/admins/{admin}', [AccountAdminController::class, 'update']);
        Route::delete('admin/admins/{admin}', [AccountAdminController::class, 'destroy']);

        // Account Management Academic Staff
        Route::get('admin/acadstaffs', [AccountAcadStaffController::class, 'index']);
        Route::post('admin/acadstaffs', [AccountAcadStaffController::class, 'store']);
        Route::get('admin/acadstaffs/{acadstaff}', [AccountAcadStaffController::class, 'show']);
        Route::put('admin/acadstaffs/{acadstaff}', [AccountAcadStaffController::class, 'update']);
        Route::delete('admin/acadstaffs/{acadstaff}', [AccountAcadStaffController::class, 'destroy']);

        // Account Management Lecturer
        Route::get('admin/lecturers', [AccountLecturerController::class, 'index']);
        Route::post('admin/lecturers', [AccountLecturerController::class, 'store']);
        Route::get('admin/lecturers/{lecturer}', [AccountLecturerController::class, 'show']);
        Route::put('admin/lecturers/{lecturer}', [AccountLecturerController::class, 'update']);
        Route::delete('admin/lecturers/{lecturer}', [AccountLecturerController::class, 'destroy']);

        // Account Management Student
        Route::get('admin/students', [AccountStudentController::class, 'index']);
        Route::post('admin/students', [AccountStudentController::class, 'store']);
        Route::get('admin/students/{student}', [AccountStudentController::class, 'show']);
        Route::put('admin/students/{student}', [AccountStudentController::class, 'update']);
        Route::delete('admin/students/{student}', [AccountStudentController::class, 'destroy']);

        // Lecturer Ranking
        Route::get('admin/lecturer-ranking', [LecturerRankingController::class, 'getLecturerRanking']);
        Route::get('admin/lecturer-ranking-by-study-program-id', [LecturerRankingController::class, 'getLecturerRankingByStudyProgramId']);
        Route::get('admin/lecturer-ranking-by-study-program-id-and-sort', [LecturerRankingController::class, 'getLecturerRankingByStudyProgramIdAndSort']);

        Route::get('admin/majors', [AdminStudentMajorController::class, 'index']);
        Route::get('admin/class', [AdminStudentClassController::class, 'index']);

        Route::get('admin/study-programs', [AdminStudyProgramController::class, 'index']);
    });

    /**
     * ROUTES FOR STUDENT
     */
    Route::middleware('role:student')->group(function () {
        // Student Questionnaires
        Route::get('student/student-questionnaires', [StudentQuestionnaireController::class, 'index']);
        Route::get('student/student-questionnaires/{studentQuestionnaire}', [StudentQuestionnaireController::class, 'show']);
        Route::post('student/student-questionnaires-tlp', [StudentQuestionnaireController::class, 'fillQuestionTLP']);
        Route::get('student/student-questionnaires/{studentQuestionnaire}/filled-tlp', [StudentQuestionnaireController::class, 'showFilledQuestionTLP']);
        Route::post('student/student-questionnaires-ac', [StudentQuestionnaireController::class, 'fillQuestionAC']);
        Route::get('student/student-questionnaires/{studentQuestionnaire}/filled-ac', [StudentQuestionnaireController::class, 'showFilledQuestionAC']);

        Route::get('student/study-programs', [StudentStudyProgramController::class, 'index']);
        Route::get('student/majors', [StudentMajorController::class, 'index']);
        Route::get('student/class', [StudentClassController::class, 'index']);
        Route::get('student/course', [StudentCourseController::class, 'index']);
        Route::get('student/lecturer-get', [StudentLecturerGetController::class, 'index']);
    });

    Route::middleware('role:lecturer')->group(function () {
        // Lecturer Questionnaires
        Route::get('lecturer/lecturer-questionnaires', [LecturerLecturerQuestionnaireController::class, 'index']);
        Route::get('lecturer/lecturer-questionnaires/{lecturerQuestionnaire}', [LecturerLecturerQuestionnaireController::class, 'show']);
        Route::post('lecturer/lecturer-questionnaires-ac', [LecturerLecturerQuestionnaireController::class, 'fillQuestion']);
        Route::get('lecturer/lecturer-questionnaires-ac/{lecturerQuestionnaire}/filled', [LecturerLecturerQuestionnaireController::class, 'showFilledQuestion']);
    });

    Route::middleware('role:acad_staff')->group(function () {
        // Lecturer Questionnaires
        Route::get('acad-staff/acad-staff-questionnaires', [AcadStaffsQuestionnaireController::class, 'index']);
        Route::get('acad-staff/acad-staff-questionnaires/{acadstaffQuestionnaire}', [AcadStaffsQuestionnaireController::class, 'show']);
        Route::post('acad-staff/acad-staff-questionnaires-ac', [AcadStaffsQuestionnaireController::class, 'fillQuestionAC']);
        Route::get('acad-staff/acad-staff-questionnaires/{acadstaffQuestionnaire}/filled', [AcadStaffsQuestionnaireController::class, 'showFilledQuestion']);
    });
});
