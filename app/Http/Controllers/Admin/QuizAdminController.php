<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Level;
use App\PendingQuiz;
use App\Question;
use App\Quiz;
use App\Subject;
use App\User;
use Illuminate\Http\Request;

class QuizAdminController extends Controller
{

    function CorrigerTestStore(Request $request){
        //dd($request->all());
        $user=User::find($request->user_id);
        $quiz=$user->quizzes()->where("quiz_id","=",$request->quiz_id)->first();
        $sum = array_sum($request->correctResponse);
        $quiz->pivot->correctQuestions+=$sum;
        $quiz->pivot->score=$quiz->pivot->correctQuestions*100/$quiz->questions->count();
    
        foreach ($request->pendigQuestion as  $pq) {
           $pend=PendingQuiz::find($pq);
           $pend->isCorrected=1;
           $pend->save();
        }
        
        $quiz->pivot->isAdminCorrection=0;
        $quiz->pivot->save();

        return back()->with("message","Test corrigé avec succès");
    }
    function CorrigerTest(){
        $quizzes=PendingQuiz::where("isCorrected","=","0")->get();
        $quizzes=$quizzes->groupBy(["user_id","quiz_id"]);

        foreach ($quizzes as $key => $value) {

            $user = User::find($key);

            $quizzes[$key]->each(function($value1,$key2) use ($user, $key,$quizzes){
                $score = $user->quizzes()->where("quiz_id","=",$key2)->first()->pivot->score;
                foreach ($value1 as $key5 => $question) {
                    $q=Question::find($question->question_id)->content;
                    $value1[$key5]["content"]=$q;
                }
                $quizzes[$key][$key2] = collect(["score"=>$score,"questions"=>$value1]);
              
            });



            $quizzes[$key]=$quizzes[$key]->keyBy(function($tests, $key1){
                return Quiz::find($key1)->title;
            });
          
        }

        $quizzes=$quizzes->keyBy(function($tests, $key){
            return User::find($key)->name;
        });
        
        
        return view("admin.results.corriger",["quizzes"=>$quizzes]);
    }

    function getTestsByModule(Subject $module){
        $quizzes = $module->quizzes()->get();
        $quizzes->each(function($quiz,$key){
            $quiz->level=$quiz->level()->first()->name;
        });
        $levels =Level::all();
        return view("admin.quizzes.testsByModule",["quizzes"=>$quizzes,"subject"=>$module,"levels"=>$levels]);
    }

    public function ResultTests(){
        //$data = User::with('quizzes')->with('grade')->where("role_id","=",2)->get();
       /*$data=User::with(array('quizzes'=> function($query) use ($quizzes){ 
            $query->wherePivot('score' , '!=' ,null);     
            $query->wherePivot('quiz_id' , '=' ,$quizzes->id);   
        }))->where("role_id","=",2)->get() ;*/
        $data = User::with("grade")->get()->filter(function ($user){
            return $user->quizzes->count()>0;
        });
        //print($data);
        //dd();
        return view("admin.results.resultTests",["data"=>$data]);
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
        //$quiz->level_id=$request->level_id;
        $quiz->duration=$request->testDuration;
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
    public function update(Request $request,Quiz $quiz)
    {
        //dd($quiz);
        //$quiz= Quiz::find($id);
        $quiz->title=$request->title;
        $quiz->description=$request->description;
        $quiz->subject_id=$request->subject_id;
        //$quiz->level_id=$request->level_id;
        $quiz->duration=$request->testDuration;
        $quiz->save();
        return back()->with("message","Test modifié avec succès");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quiz::find($id)->delete();
        return back()->with('message','Test supprimé avec succès !');
    }
}
