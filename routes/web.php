<?php

use Illuminate\Support\Facades\Route;

//prefix "admin"
Route::prefix('admin')->group(function () {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');

        //route resource lessons    
        Route::resource('/lessons', \App\Http\Controllers\Admin\LessonController::class, ['as' => 'admin']);

        //route resource classrooms    
        Route::resource('/classrooms', \App\Http\Controllers\Admin\ClassroomController::class, ['as' => 'admin']);

        //route student import
        Route::get('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'import'])->name('admin.students.import');

        //route student store import
        Route::post('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'storeImport'])->name('admin.students.storeImport');

        //route resource students    
        Route::resource('/students', \App\Http\Controllers\Admin\StudentController::class, ['as' => 'admin']);

        //route lecturer import
        Route::get('/lecturer/import', [\App\Http\Controllers\Admin\LecturerController::class, 'import'])->name('admin.lecturer.import');

        //route lecturer store import
        Route::post('/lecturer/import', [\App\Http\Controllers\Admin\LecturerController::class, 'storeImport'])->name('admin.lecturer.storeImport');

        //route resource lecturer    
        Route::resource('/lecturer', \App\Http\Controllers\Admin\LecturerController::class, ['as' => 'admin']);

        //route resource exams    
        Route::resource('/exams', \App\Http\Controllers\Admin\ExamController::class, ['as' => 'admin']);

        //custom route for create question exam
        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Admin\ExamController::class, 'createQuestion'])->name('admin.exams.createQuestion');

        //custom route for store question exam
        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Admin\ExamController::class, 'storeQuestion'])->name('admin.exams.storeQuestion');

        //custom route for edit question exam
        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'editQuestion'])->name('admin.exams.editQuestion');

        //custom route for update question exam
        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Admin\ExamController::class, 'updateQuestion'])->name('admin.exams.updateQuestion');

        //custom route for destroy question exam
        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Admin\ExamController::class, 'destroyQuestion'])->name('admin.exams.destroyQuestion');

        //route student import
        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'import'])->name('admin.exam.questionImport');

        //route student import
        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'storeImport'])->name('admin.exam.questionStoreImport');

        //route resource exam_sessions    
        Route::resource('/exam_sessions', \App\Http\Controllers\Admin\ExamSessionController::class, ['as' => 'admin']);

        //custom route for enrolle create
        Route::get('/exam_sessions/{exam_session}/enrolle/create', [\App\Http\Controllers\Admin\ExamSessionController::class, 'createEnrolle'])->name('admin.exam_sessions.createEnrolle');

        //custom route for enrolle store
        Route::post('/exam_sessions/{exam_session}/enrolle/store', [\App\Http\Controllers\Admin\ExamSessionController::class, 'storeEnrolle'])->name('admin.exam_sessions.storeEnrolle');

        //custom route for enrolle destroy
        Route::delete('/exam_sessions/{exam_session}/enrolle/{exam_group}/destroy', [\App\Http\Controllers\Admin\ExamSessionController::class, 'destroyEnrolle'])->name('admin.exam_sessions.destroyEnrolle');

        //route index reports
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');

        //route index reports filter
        Route::get('/reports/filter', [\App\Http\Controllers\Admin\ReportController::class, 'filter'])->name('admin.reports.filter');

        //route index reports export
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');
    });
});

// ----------------------------- start student
//route homepage
Route::get('/', function () {

    //cek session student
    if (auth()->guard('student')->check()) {
        return redirect()->route('student.dashboard');
    }

    //return view login
    return \Inertia\Inertia::render('Student/Login/Index');
});

//login students
Route::post('/students/login', \App\Http\Controllers\Student\LoginController::class)->name('student.login');

//prefix "student"
Route::prefix('student')->group(function () {

    //middleware "student"
    Route::group(['middleware' => 'student'], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Student\DashboardController::class)->name('student.dashboard');

        //route exam confirmation
        Route::get('/exam-confirmation/{id}', [App\Http\Controllers\Student\ExamController::class, 'confirmation'])->name('student.exams.confirmation');

        //route exam start
        Route::get('/exam-start/{id}', [App\Http\Controllers\Student\ExamController::class, 'startExam'])->name('student.exams.startExam');

        //route exam show
        Route::get('/exam/{id}/{page}', [App\Http\Controllers\Student\ExamController::class, 'show'])->name('student.exams.show');

        //route exam update duration
        Route::put('/exam-duration/update/{grade_id}', [App\Http\Controllers\Student\ExamController::class, 'updateDuration'])->name('student.exams.update_duration');

        //route answer question
        Route::post('/exam-answer', [App\Http\Controllers\Student\ExamController::class, 'answerQuestion'])->name('student.exams.answerQuestion');

        //route exam end
        Route::post('/exam-end', [App\Http\Controllers\Student\ExamController::class, 'endExam'])->name('student.exams.endExam');

        //route exam result
        Route::get('/exam-result/{exam_group_id}', [App\Http\Controllers\Student\ExamController::class, 'resultExam'])->name('student.exams.resultExam');
    });

});
// ----------------------------- end student

// ----------------------------- start dosen
//route homepage
Route::get('/logindosen', function () {

    //cek session lecturer
    if (auth()->guard('lecturer')->check()) {
        return redirect()->route('lecturer.dashboard');
    }

    //return view login
    return \Inertia\Inertia::render('Lecturer/Login/Index');
});

//login lecturers
Route::post('/lecturers/login', \App\Http\Controllers\Lecturer\LoginController::class)->name('lecturer.login');

//prefix "lecturer"
Route::prefix('lecturer')->group(function () {
    
    //middleware "lecturer"
    Route::group(['middleware' => 'lecturer'], function () {
        
        Route::get('/dashboard', App\Http\Controllers\Lecturer\DashboardController::class)->name('lecturer.dashboard');
        Route::resource('/exams', \App\Http\Controllers\Lecturer\ExamController::class, ['as' => 'lecturer']);
        Route::resource('/exam_sessions', \App\Http\Controllers\Lecturer\ExamSessionController::class, ['as' => 'lecturer']);
        Route::get('/reports', [\App\Http\Controllers\Lecturer\ReportController::class, 'index'])->name('lecturer.reports.index');
        
        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Lecturer\ExamController::class, 'createQuestion'])->name('lecturer.exams.createQuestion');

        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Lecturer\ExamController::class, 'storeQuestion'])->name('lecturer.exams.storeQuestion');

        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Lecturer\ExamController::class, 'editQuestion'])->name('lecturer.exams.editQuestion');

        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Lecturer\ExamController::class, 'updateQuestion'])->name('lecturer.exams.updateQuestion');

        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Lecturer\ExamController::class, 'destroyQuestion'])->name('lecturer.exams.destroyQuestion');

        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Lecturer\ExamController::class, 'import'])->name('lecturer.exam.questionImport');

        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Lecturer\ExamController::class, 'storeImport'])->name('lecturer.exam.questionStoreImport');

        Route::get('/exam_sessions/{exam_session}/enrolle/create', [\App\Http\Controllers\Lecturer\ExamSessionController::class, 'createEnrolle'])->name('lecturer.exam_sessions.createEnrolle');

        Route::post('/exam_sessions/{exam_session}/enrolle/store', [\App\Http\Controllers\Lecturer\ExamSessionController::class, 'storeEnrolle'])->name('lecturer.exam_sessions.storeEnrolle');

        Route::delete('/exam_sessions/{exam_session}/enrolle/{exam_group}/destroy', [\App\Http\Controllers\Lecturer\ExamSessionController::class, 'destroyEnrolle'])->name('lecturer.exam_sessions.destroyEnrolle');


        Route::get('/reports/filter', [\App\Http\Controllers\Lecturer\ReportController::class, 'filter'])->name('lecturer.reports.filter');

        Route::get('/reports/export', [\App\Http\Controllers\Lecturer\ReportController::class, 'export'])->name('lecturer.reports.export');


        // Route::get('/dashboard', App\Http\Controllers\Lecturer\DashboardController::class)->name('lecturer.dashboard');
        // Route::resource('/exams', \App\Http\Controllers\Lecturer\ExamController::class, ['as' => 'lecturer']);
        // Route::resource('/exam_sessions', \App\Http\Controllers\Lecturer\ExamSessionController::class, ['as' => 'lecturer']);
        // Route::get('/reports', [\App\Http\Controllers\Lecturer\ReportController::class, 'index'])->name('lecturer.reports.index');

    });

});
// ----------------------------- end dosen
