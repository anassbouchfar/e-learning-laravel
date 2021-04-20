<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'score', 'level_id','subject_id'
    ];

    public function user(){
        return $this->belongsTo("App\User");
    }
}
