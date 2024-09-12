<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return 'Welcome to the Laravel 8 Multi Auth System';
// });

Route::get('/auth/admin', function () {
    return view('auth.admin');
});

Route::get('/auth/lecturer', function () {
    return view('auth.lecturer');
});

Route::get('/auth/student', function () {
    return view('auth.student');
});

Route::get('/auth/acadstaff', function () {
    return view('auth.acadstaff');
});

// Rute untuk mahasiswa yang memerlukan autentikasi
Route::middleware(['auth:student'])->group(function () {
    Route::get('/questionnaire/select-student', function () {
        return view('questionnaire.selectStudent');
    });
    Route::get('/questionnaire/tlp-student', function () {
        return view('questionnaire.studentTLP');
    });
    Route::get('/questionnaire/ac-student', function () {
        return view('questionnaire.studentAC');
    });
    Route::post('/student/logout', function () {
        Auth::logout();
        return redirect('/auth/student');
    })->name('student.logout');
});

Route::middleware(['auth:lecturer'])->group(function () {
    Route::get('/questionnaire/select-lecturer', function () {
        return view('questionnaire.selectLecturer');
    });

    Route::get('/questionnaire/ac-lecturer', function () {
        return view('questionnaire.lecturerAC');
    });

    Route::post('/lecturer/logout', function () {
        Auth::logout();
        return redirect('/auth/lecturer');
    })->name('lecturer.logout');
});

Route::middleware(['auth:acad_staff'])->group(function () {
    Route::get('/questionnaire/ac-acadstaff', function () {
        return view('questionnaire.acadstaffAC');
    });

    Route::get('/questionnaire/select-acadstaff', function () {
        return view('questionnaire.selectAcadStaff');
    });

    Route::post('/acadstaff/logout', function () {
        Auth::logout();
        return redirect('/auth/acadstaff');
    })->name('acadstaff.logout');

});


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/questionnaire-student', function () {
        return view('admin.student.questionnaireStudent');
    })->name('admin.student.questionnaire');

    Route::get('/admin/questionnaire-student/fill', function () {
        return view('admin.student.questionnaireStudentfill');
    })->name('admin.student.questionnairefill');

    Route::get('/admin/element-student', function () {
        return view('admin.student.elementStudent');
    })->name('admin.student.element');

    Route::get('/admin/question-student', function () {
        return view('admin.student.questionStudent');
    })->name('admin.student.question');

    Route::get('/admin/questionnaire-student/ranking', function () {
        return view('admin.student.rangkingLecturer');
    })->name('admin.student.rangking');

    Route::get('/admin/questionnaire-lecturer', function () {
        return view('admin.lecturer.questionnaireLecturer');
    })->name('admin.lecturer.questionnaire');

    Route::get('/admin/questionnaire-lecturer/fill', function () {
        return view('admin.lecturer.questionnaireLecturerfill');
    })->name('admin.lecturer.questionnairefill');

    Route::get('/admin/element-lecturer', function () {
        return view('admin.lecturer.elementLecturer');
    })->name('admin.lecturer.element');

    Route::get('/admin/question-lecturer', function () {
        return view('admin.lecturer.questionLecturer');
    })->name('admin.lecturer.question');

    Route::get('/admin/questionnaire-acadstaff', function () {
        return view('admin.acadstaff.questionnaireAcadstaff');
    })->name('admin.acadstaff.questionnaire');

    Route::get('/admin/questionnaire-acadstaff/fill', function () {
        return view('admin.acadstaff.questionnaireAcadstafffill');
    })->name('admin.acadstaff.questionnairefill');

    Route::get('/admin/element-acadstaff', function () {
        return view('admin.acadstaff.elementAcadstaff');
    })->name('admin.acadstaff.element');

    Route::get('/admin/question-acadstaff', function () {
        return view('admin.acadstaff.questionAcadstaff');
    })->name('admin.acadstaff.question');

    Route::get('/admin/manage-admin', function () {
        return view('admin.manage.admin');
    })->name('admin.manage.admin');

    Route::get('/admin/manage-student', function () {
        return view('admin.manage.student');
    })->name('admin.manage.student');

    Route::get('/admin/manage-lecturer', function () {
        return view('admin.manage.lecturer');
    })->name('admin.manage.lecturer');

    Route::get('/admin/manage-acadstaff', function () {
        return view('admin.manage.acadstaff');
    })->name('admin.manage.acadstaff');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/auth/admin');
    })->name('admin.logout');
});



