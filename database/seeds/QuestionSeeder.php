<?php

use App\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //levels
        foreach(range(1,3) as $level_id){
            $this->generateRandomQuestions(1,30,$level_id);
        }

    }

    function generateRandomQuestions($subjectId,$nbOfQuestions,$level_id){
            //multiple_choice
       factory(App\Question::class, $nbOfQuestions)->create(["level_id"=>$level_id,"subject_id"=>$subjectId,"type_question"=>"multiple_choice","boolean_answer"=>null])->each(function ($question) {
            $correctChoice=factory(App\Choice::class)->make(["isCorrect"=>1]);
            $otherChoices=factory(App\Choice::class,3)->make(["isCorrect"=>0]);
            $otherChoices->push($correctChoice);
            $question->choices()->saveMany($otherChoices);
        });


        //multiple_answers
        factory(App\Question::class, $nbOfQuestions)->create(["level_id"=>$level_id,"subject_id"=>$subjectId,"type_question"=>"multiple_answers","boolean_answer"=>null])->each(function ($question) {
            $correctChoice=factory(App\Choice::class,2)->make(["isCorrect"=>1]);
            $otherChoices=factory(App\Choice::class,3)->make(["isCorrect"=>0]);
            $question->choices()->saveMany($otherChoices->concat($correctChoice));
        });



        //boolean

        factory(App\Question::class, $nbOfQuestions/2)->create(["level_id"=>$level_id,"subject_id"=>$subjectId,"type_question"=>"boolean","boolean_answer"=>0]);
        factory(App\Question::class, $nbOfQuestions/2)->create(["level_id"=>$level_id,"subject_id"=>$subjectId,"type_question"=>"boolean","boolean_answer"=>1]);
    }

}
