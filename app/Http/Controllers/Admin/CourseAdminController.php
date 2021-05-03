<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course=new Course();
        $file = $request->file('cours_pdf'); 
        $file_name = time().'.'.$file->getClientOriginalName();
        $file->move(public_path('cours') , $file_name); // move files to destination folder
        $course->pdf_path=$file_name;
        $course->title=$request->title;
        $course->Description=$request->Description;
        $course->subject_id=$request->subject_id;
        $course->save();
        return back()->with('message','Cours ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        
        if ($request->hasFile('cours_pdf')) {
            $file = $request->file('cours_pdf'); 
            $file_name = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('cours') , $file_name); // move files to destination folder
            $course->pdf_path=$file_name;
        }

        $course->title=$request->title;
        $course->Description=$request->Description;
        $course->save();
        return back()->with('message','Cours modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('message','Cours supprimé avec succès !');
    }
}
