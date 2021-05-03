<?php

namespace App\Imports;

use App\Choice;
use App\Question;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionInmport implements ToModel
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
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
                foreach(range(2,5) as $i){
                    if($i==2) $choice =new Choice(["content"=>$row[$i],"isCorrect"=>1]);
                    else{
                        $choice =new Choice(["content"=>$row[$i]]);
                    }
                    array_push($choices,$choice);
                }
                    
                    $question->choices()->saveMany($choices);
                break;
                case "multiple_answers": 
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
        }
        
        return $question;
    }
}
