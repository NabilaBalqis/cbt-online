<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //validate the form data
        $request->validate([
            'nisn'      => 'required',
            'password'  => 'required',
        ]);

        //cek nisn dan password
        $student = Student::where([
            'nisn'      => $request->nisn,
            'password'  => $request->password
        ])->first();

        if(!$student) {
            return redirect()->back()->with('error', 'NISN atau Password salah');
        }
        
        //login the user
        auth()->guard('student')->login($student);

        //redirect to dashboard
        return redirect()->route('student.dashboard');
    }
}