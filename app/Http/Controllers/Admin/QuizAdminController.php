<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Level;
use App\Quiz;
use App\Subject;
use Illuminate\Http\Request;

class QuizAdminController extends Controller
{



    function getTestsByModule(Subject $module){
        $quizzes = $module->quizzes()->get();
        $quizzes->each(function($quiz,$key){
            $quiz->level=$quiz->level()->first()->name;
        });
        $levels =Level::all();
        return view("admin.quizzes.testsByModule",["quizzes"=>$quizzes,"subject"=>$module,"levels"=>$levels]);
    }

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
        $quiz= new Quiz();
        $quiz->title=$request->title;
        $quiz->description=$request->description;
        $quiz->subject_id=$request->subject_id;
        $quiz->level_id=$request->level_id;
        $quiz->save();
        return back()->with("message","Test ajouté avec succès");
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
