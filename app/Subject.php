<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function courses(){
        return $this->hasMany("App\Course");
    }

    public function questions(){
        return $this->hasMany("App\Question");
    }

    public function quizzes(){
        return $this->hasMany("App\Quiz");
    }
}
