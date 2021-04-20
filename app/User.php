<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cin', 'password','id_role','id_grade'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function quizzes(){
        return $this->belongsToMany("App\Quiz")
                    ->withPivot(['score']);
    }

    public function courses(){
        return $this->belongsToMany("App\Course")
                    ->withPivot(['currentPage','progression']);
    }

    public function trainings(){
        return $this->hasMany("App\Training");
    }
}
