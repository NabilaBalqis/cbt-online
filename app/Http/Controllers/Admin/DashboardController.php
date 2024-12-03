<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classroom;
use App\Models\ExamSession;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     * *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //count students
        $students = Student::count();

        //count lecturer
        $lecturer = Lecturer::count();

        //count exams
        $exams = Exam::count();

        //count exam sessions
        $exam_sessions = ExamSession::count();

        //count classrooms
        $classrooms = Classroom::count();

        return inertia('Admin/Dashboard/Index', [
            'students'      => $students,
            'lecturer'      => $lecturer,
            'exams'         => $exams,
            'exam_sessions' => $exam_sessions,
            'classrooms'    => $classrooms,
        ]);
    }
}
