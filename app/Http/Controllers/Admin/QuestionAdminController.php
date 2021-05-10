<?php

namespace App\Http\Controllers\Admin;

use App\Choice;
use App\Http\Controllers\Controller;
use App\Imports\QuestionInmport;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Facades\Excel;
use App\Question;
use App\Quiz;

class QuestionAdminController extends Controller
{

    public function addQuestion(Request $request){
        //dd($request->all());
        $question =new Question;
        if ($request->hasFile('questionImage')) {
            $file = $request->file('questionImage'); 
            $file_name = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('picturesTests') , $file_name); // move files to destination folder
            $question->image_path=$file_name;
        }
        $question->content = $request->content;
        switch($request->type_question){
            case 1:
                $question->type_question="multiple_choice";
                $choices=array();
                foreach ($request->choix as $key => $choix) {
                    if($choix){
                        $choice=new Choice();
                        $choice->content=$choix;
                        if(($key+1)==$request->TrueChoice) $choice->isCorrect=1;
                        array_push($choices,$choice);
                    }
                    
                }
                
                break;
            case 2:
                $question->type_question="multiple_answers";
                $choices=array();
                foreach ($request->choix as $key => $choix) {
                    if($choix){
                        $choice=new Choice();
                        $choice->content=$choix;
                        if( in_array(($key+1),$request->TrueChoice)) $choice->isCorrect=1;
                        array_push($choices,$choice);
                    }
                    
                }
                break;
            case 3:
                $question->type_question="boolean";
                $question->boolean_answer=$request->choiceBool;
                break;
            case 4:
                $question->type_question="input";
                break;
        }
        if($request->subject_id){
            $question->subject_id = $request->subject_id;
            $question->save();
        }else{
            $question->save();
            $question->quizzes()->attach($request->quiz_id);
        }
        if(isset($choices))
            $question->choices()->saveMany($choices);
        
        return back()->with("message","Question ajouté avec succès");
    }
    
    function uploadQuestionsEntrainement(Request $request){
        $collection=(new QuestionInmport)->toArray($request->file("questionsFile"));  
        foreach ($collection[0]  as $row) 
            $this->addTrainingQuestions($row,$request->subject_id);
            
        
        return back()->with("message","Questions ajoutées avec succès");
    }

    function uploadQuestions(Request $request){
        //Excel::import(new QuestionInmport,$request->file("questionsFile"));
        $collection=(new QuestionInmport)->toArray($request->file("questionsFile"));  
        $msg="Questions ajoutées avec succès";
        $this->addQuestionsToTest($request->quiz_id,$collection[0]) ?? $msg="Questions Non ajoutées"; 
        
        return back()->with("message",$msg);
    }


    function addQuestionsToTest($quiz_id,$collection){
        
        $questions=array();
        foreach ($collection  as $row) {
            $question=$this->addTestQuestions($row);
            array_push($questions,$question);
        }
        
        $quiz = Quiz::find($quiz_id);
        $quiz->questions()->saveMany($questions);
        return True;
    }

    function addTestQuestions(array $row){
        //dd($row);
        $question=new Question;
        $question->type_question=$row[1];
        $question->content=$row[0];
        if($row[1]=="boolean"){
            $question->boolean_answer=$row[2];
             $question->save();
             return $question;
        }else if ($row[1]=="input"){
            $question->save();
             return $question;
        }
        $question->save();
        switch($row[1]){
            case "multiple_choice":
                $choices=array();
                $choice =new Choice(["content"=>$row[2],"isCorrect"=>1]);
                array_push($choices,$choice);
                $i=3;
                while(isset($row[$i])){
                    $choice =new Choice(["content"=>$row[$i]]);
                    array_push($choices,$choice);
                    $i++;
                }
                    $question->choices()->saveMany($choices);
                break;
                case "multiple_answers": 
                        $choices=array();
                        $i=2;
                        while(isset($row[$i])){
                            $choice =new Choice(["content"=>$row[$i],"isCorrect"=>1]);
                            array_push($choices,$choice);
                            $i++;
                        }
                        $i++;
                        while(isset($row[$i])){
                            $choice =new Choice(["content"=>$row[$i]]);
                            array_push($choices,$choice);
                            $i++;
                        }
                        $question->choices()->saveMany($choices);
                    break;
        }
        
        return $question;
    }

    function addTrainingQuestions(array $row,$subject_id){
        //dd($row);
        $question=new Question;
        $question->content=$row[0];
        $question->level_id=$row[1];
        $question->type_question=$row[2];
        $question->subject_id=$subject_id;
        if($row[3]) $question->explication=$row[3];
        if($row[2]=="boolean"){
            $question->boolean_answer=$row[4];
             $question->save();
             return $question;
        }
        $question->save();
        switch($row[2]){
            case "multiple_choice":
                $choices=array();
                $choice =new Choice(["content"=>$row[4],"isCorrect"=>1]);
                array_push($choices,$choice);
                $i=5;
                while(isset($row[$i])){
                    $choice =new Choice(["content"=>$row[$i]]);
                    array_push($choices,$choice);
                    $i++;
                }
                    array_push($choices,$choice);
                    $question->choices()->saveMany($choices);
                break;

                case "multiple_answers": 
                        $choices=array();
                        $i=4;
                        while(isset($row[$i])){
                            $choice =new Choice(["content"=>$row[$i],"isCorrect"=>1]);
                            array_push($choices,$choice);
                            $i++;
                        }

                        $i++;
                        while(isset($row[$i])){
                            $choice =new Choice(["content"=>$row[$i]]);
                            array_push($choices,$choice);
                            $i++;
                        }
                        $question->choices()->saveMany($choices);
                    break;
        }
        
        return $question;
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
        //
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
