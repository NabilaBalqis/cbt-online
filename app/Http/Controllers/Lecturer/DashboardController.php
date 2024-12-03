<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
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
        //count exams
        $exams = Exam::count();

        //count exam sessions
        $exam_sessions = ExamSession::count();

        return inertia('Lecturer/Dashboard/Index', [
            'exams' => $exams,
            'exam_sessions' => $exam_sessions,
        ]);
    }
}
