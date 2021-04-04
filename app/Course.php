<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function users(){
        return $this->belongsToMany("App\User")
                    ->withPivot(['currentPage','progression']);
    }

    public function subject(){
        return $this->belongsTo("App\Subject");
    }
}
