<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Classroom;
use App\Imports\LecturerImport;
use Maatwebsite\Excel\Facades\Excel;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get lecturer
        $lecturers = Lecturer::when(request()->q, function($lecturers) {
            $lecturers = $lecturers->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $lecturers->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Lecturer/Index', [
            'lecturers' => $lecturers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Lecturer/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'name'          => 'required|string|max:255',
            'nip'           => 'required|unique:lecturer',
            'address'       => 'required|string|max:255',
            'gender'        => 'required|string',
            'password'      => 'required|confirmed',
        ]);

        //create lecturer
        Lecturer::create([
            'name'          => $request->name,
            'nip'           => $request->nip,
            'address'       => $request->address,
            'gender'        => $request->gender,
            'password'      => $request->password,
        ]);

        //redirect
        return redirect()->route('admin.lecturer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        //get lecturer
        $lecturer = Lecturer::findOrFail($id);

        //render with inertia
        return inertia('Admin/Lecturer/Edit', [
            'lecturer' => $lecturer,
            // 'address' => $address,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        //validate request
        $request->validate([
            'nip'           => 'required|unique:lecturer,nip,'.$lecturer->id,
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'gender'        => 'required|string',
            'password'      => 'confirmed'
        ]);

        //check passwordy
        if($request->password == "") {

            //update student without password
            $lecturer->update([
                'nip'           => $request->nip,
                'name'          => $request->name,
                'address'       => $request->address,
                'gender'        => $request->gender
            ]);

        } else {

            //update student with password
            $lecturer->update([
                'nip'           => $request->nip,
                'name'          => $request->name,
                'address'       => $request->address,
                'gender'        => $request->gender,
                'password'      => $request->password
            ]);

        }

        //redirect
        return redirect()->route('admin.lecturer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get student
        $lecturer = Lecturer::findOrFail($id);

        //delete student
        $lecturer->delete();

        //redirect
        return redirect()->route('admin.lecturer.index');
    }

    /**
     * import
     *
     * @return void
     */
    public function import()
    {
        return inertia('Admin/Lecturer/Import');
    }
    
    /**
     * storeImport
     *
     * @param  mixed $request
     * @return void
     */
    public function storeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new LecturerImport(), $request->file('file'));

        //redirect
        return redirect()->route('admin.lecturer.index');
    }
}
