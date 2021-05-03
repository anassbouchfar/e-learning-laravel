<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    function Quizzes(){
        return $this->hasMany("App\Quiz");
    }
}
