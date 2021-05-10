<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingQuiz extends Model
{
    public function users(){
        return $this->hasMany("App\User");
    }
    public function questions(){
        return $this->hasMany("App\Question");
    }
    public function quizzes(){
        return $this->hasMany("App\Quiz");
    }
}
