<?php

namespace App\Providers;

use App\PendingQuiz;
use App\User;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('user.layouts.master2', function ($view) 
            {
                if(Auth::check()){
                    if(Auth::user()->role_id==2){
                        $quizzes = Auth::User()->quizzes()->get() ;
                        $nbquizzesNotPassed=$quizzes->filter(function($quiz){
                            return $quiz->pivot->score===NULL;
                        })->count();

                        $view->with('nbquizzesNotPassed', $nbquizzesNotPassed ); 
                    }
                }
                   
            }); 
            

            view()->composer('admin.layouts.master', function ($view) 
            {
                if(Auth::check()){
                    if(Auth::user()->role_id==1){
                        $users = User::where("role_id","=","2")->count();
                        $Result_tests = User::with("grade")->get()->filter(function ($user){
                            return $user->quizzes->count()>0;
                        })->count();
                
                        $quizzes=PendingQuiz::where("isCorrected","=","0")->get();
                        $quizzes=$quizzes->groupBy(["user_id","quiz_id"])->count();
        
                        $view->with(['nbOfUsers'=>$users,'Result_tests'=>$Result_tests,"nbTestsAcorriger"=>$quizzes]);
                    }
                }
             
            });
        
    }
}
