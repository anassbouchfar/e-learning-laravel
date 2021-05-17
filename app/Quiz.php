<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function users(){
        return $this->belongsToMany("App\User")->withTimestamps();;
    }

    public function questions(){
        return $this->belongsToMany("App\Question");
    }
    public function subject(){
        return $this->belongsTo("App\Subject");
    }

    public function level(){
        return $this->belongsTo("App\Level");
    }
}
