<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;

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
            'nip'       => 'required',
            'password'  => 'required',
        ]);

        //cek nisn dan password
        $lecturer = Lecturer::where([
            'nip'       => $request->nip,
            'password'  => $request->password
        ])->first();

        if(!$lecturer) {
            return redirect()->back()->with('error', 'NIP atau Password salah');
        }
        
        //login the user
        auth()->guard('lecturer')->login($lecturer);

        //redirect to dashboard
        return redirect()->route('lecturer.dashboard');
    }
}
