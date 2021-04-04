<?php

namespace App\Http\Controllers;

use App\Cours;
use App\Course;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Util\Json;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCourses=Course::all();
        $myCourses = Auth::user()->courses()->get();
        return view('user.course.index',["allCourses"=>$allCourses,"myCourses"=>$myCourses]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function show(Course $cour)
    {   
        //->where("id","=",Auth::id())
        $course=$cour->users()->where("id","=",Auth::id())->first();
       $cour->pivot=$course->pivot;
        return view('user.course.show',["course"=>$cour]);
    }

    public function commencer(Course $course){
        $user=Auth::user();
        $user->courses()->attach($course->id);
        return $this->show($course);
    }

    public function updateCurrentPageAndProgCourse(Request $request){
        $course=Auth::user()->courses()->find($request->courseId);
        $course->pivot->currentPage=$request->pageNum;
        $prog=$request->pageNum*100/$request->allPages;
        $course->pivot->progression= number_format($prog,2);
        $course->pivot->save();
        return Response()->json(["msg"=>["prog1"=>$prog]]);
    }
   /* public function updateProgression(Request $request){
        return Response()->json(["msg"=>$request->all()]);
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function edit(Cours $cours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cours $cours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cours $cours)
    {
        //
    }
}
