<?php

namespace App\Http\Controllers;

use App\Level;
use App\Training;
use App\Subject;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects=Subject::all();
        $histoTrainings=Auth::user()->trainings()->get();
        $histoTrainings=$histoTrainings->map(function($training){
            $training->subject_name=Subject::find($training->subject_id)->title;
            $training->level_name=Level::find($training->level_id)->name;
            return $training;
        });
        return view("user.training.index",["subjects"=>$subjects,"histoTrainings"=>$histoTrainings]);
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
        $score = QuizController::correction($request);
        $nbOfQuestions=count($request->QuestionId);
        $scoreWithPercent = number_format($score*100/$nbOfQuestions,2);
        $subject=Subject::find($request->subject_id);
        $level=Level::find($request->level_id);
        Training::create(["user_id"=>Auth::id(),"score"=>$scoreWithPercent,"level_id"=>$request->level_id,"subject_id"=>$request->subject_id]);
        return view("user.training.resultTrain",["subject"=>$subject,"totalQuestions"=>$nbOfQuestions,"level"=>$level,"score"=>$score,"scoreWithPercent"=>$scoreWithPercent]);
    }

    public function trainingLevels(Request $request){
        $subject_id=$request->subject_id;
        $level_id=$request->level_id;

        $subject=Subject::FindOrFail($subject_id);
        $questionsBeginner = $subject->questions()->where("level_id","=",1)->get();
        $questionsIntermediate = $subject->questions()->where("level_id","=",2)->get();
        $questionsAdvanced = $subject->questions()->where("level_id","=",3)->get();
        
        switch($level_id){
            case 1 : 
                $questionsBeginner=$questionsBeginner->random(1);
                $questionsIntermediate=$questionsIntermediate->random(1);
                $questionsAdvanced=$questionsAdvanced->random(1);
                break;
            case 2 : 
                $questionsBeginner=$questionsBeginner->random(6);
                $questionsIntermediate=$questionsIntermediate->random(10);
                $questionsAdvanced=$questionsAdvanced->random(4);             
                   break;
            case 3 : 
                $questionsBeginner=$questionsBeginner->random(2);
                $questionsIntermediate=$questionsIntermediate->random( 4);
                $questionsAdvanced=$questionsAdvanced->random(14);              
                  break;
        }
        $questionsBeginner = $this->addChoices($questionsBeginner);    
        $questionsIntermediate = $this->addChoices($questionsIntermediate);
        $questionsAdvanced = $this->addChoices($questionsAdvanced);


        return view("user.training.passTrain",["level"=>Level::find($level_id),"subject"=>Subject::find($subject_id),"questionsBeginner"=>$questionsBeginner,"questionsIntermediate"=>$questionsIntermediate,"questionsAdvanced"=>$questionsAdvanced]);
    }

    function addChoices($questions){
        return $questions->map(function($question){
            if($question->type_question=="boolean") {
                $question->correct= $question->boolean_answer ? "True" : "False";
                return $question;
            }
            $choices=$question->choices()->get();
            $question->choices = $choices->shuffle();
            $question->correct=$question->choices()->where("isCorrect","=",1)->get();
            return $question;
        });   
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show($subjectId)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        //
    }
}
