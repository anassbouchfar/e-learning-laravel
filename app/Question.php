<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function quizzes(){
        return $this->belongsToMany("App\Quiz");
    }

    public function choices(){
        return $this->hasMany("App\Choice");
    }

    public function subject(){
        return $this->belongsTo("App\Subject");
    }
}
