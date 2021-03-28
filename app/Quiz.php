<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function users(){
        return $this->belongsToMany("App\User");
    }

    public function questions(){
        return $this->belongsToMany("App\Question");
    }
}
