<?php

namespace App\Http\Controllers;

use App\Question;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //->where("score","is","NULL")->orderBy("created_at")
        $quizzes = Auth::user()->quizzes()->get() ;
        $quizzesNotPassed=$quizzes->filter(function($quiz){
            return $quiz->pivot->score==NULL;
        });
        $quizzesPassed=$quizzes->filter(function($quiz){
            return $quiz->pivot->score!=NULL;
        });
        return view("user.quiz",["quizzes"=>$quizzesNotPassed,'quizzesPassed'=>$quizzesPassed]);
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
        $quiz=Quiz::find($request->QuizId);
        if($this->isContainInputQuestion($quiz)){
            dd("input quizz");
        }
        $score = $this->correction($request);
        $nbOfQuestions=$quiz->questions()->count();
        $scoreWithPercent = number_format($score*100/$nbOfQuestions,2);
         $quizwithUser=Auth::user()->quizzes()->where("id","=",$quiz->id)->first();
         $quizwithUser->pivot->score=$scoreWithPercent;
         $quizwithUser->pivot->correctQuestions=$score;
         $quizwithUser->pivot->save();
        return view("user.resultQuiz",["quiz"=>$quizwithUser,"totalQuestions"=>$nbOfQuestions]);
    }

    public static function correction(Request $request){
        //test

        $score=0;
        foreach ($request->QuestionId as $QuestionId) {
            $user_response = $request->option[$QuestionId];
            $question  = Question::find($QuestionId);
                switch ($question->type_question) {
                    case "boolean":
                        $user_response=="true" ? $user_response=true : $user_response=false;
                        if($question->boolean_answer==$user_response)  $score++  ;
                        break;
                    case "multiple_choice":
                        $choices=$question->choices()->get();
                        $correct_choice= $choices->filter(function($choice){
                            return $choice->isCorrect==1;
                        });
                        if($correct_choice->first()->id==$user_response) $score++ ;
                        break;
                    case "multiple_answers":
                        $choices=$question->choices()->get();
                        $correct_answers= $choices->filter(function($choice){
                            return $choice->isCorrect==1;
                        })->pluck("id")->toArray();
                        
                        $diff1 = array_diff($user_response,$correct_answers);
                        $diff2 = array_diff($correct_answers,$user_response);
                    
                        if(!$diff1 && !$diff2) $score++ ;
                        break;
                    default:
                        
                        break;
                }
        }
        return $score;
    }



    private function isContainInputQuestion(Quiz $quiz){
        $questions=$quiz->questions()->get();
        
        foreach ($questions as $question) {
            if($question->type_question=="input") return True;
        }
        return False;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {   
        $questions =$quiz->questions()->get()->map(function($question){
            $choices=$question->choices()->get();
            $question->choices = $choices;
            unset($question->pivot);
            return $question;
        });        
        return view("user.Passquiz",["quiz"=>$quiz,"questions"=>$questions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        
    }
}
