<?php

use App\PendingQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("test");

Auth::routes();


//userRole
Route::get("/changePasswordForm","Admin\UserAdminController@changePasswordForm")->name("changePasswordForm");


Route::group(["as"=>"user.","middleware"=>['auth','userRole']],function(){
  
    Route::get('home', function(){
        return view('user.index');
    })->name('home');

    //Route::get('cours',"coursController@index")->name('cours');
    Route::resource("cours","courseController");
    Route::resource("quizzes","quizController");
    Route::resource("modules","subjectController");
    Route::resource("Training","TrainingController");
    Route::get("commencer/{course}","courseController@commencer")->name("cours.commencer");
    Route::post("updateCurrentPageAndProgCourse","courseController@updateCurrentPageAndProgCourse");
   // Route::post("updateProgressionCourse","courseController@updateProgression");
    Route::post("/trainingLevels","TrainingController@trainingLevels");
    

});


Route::group(["as"=>"admin.","prefix"=>"admin","middleware"=>['auth','adminRole']],function(){
    Route::get('home', function(){
        return view('admin.index');
    })->name('home');
    Route::resource("modules","Admin\ModuleAdminController");
    Route::resource("courses","Admin\CourseAdminController");
    Route::resource("questions","Admin\QuestionAdminController");
    Route::post("uploadQuestions","Admin\QuestionAdminController@uploadQuestions")->name("uploadQuestions");
    Route::post("uploadQuestionsEntrainement","Admin\QuestionAdminController@uploadQuestionsEntrainement")->name("uploadQuestionsEntrainement");
    Route::post("addQuestion","Admin\QuestionAdminController@addQuestion")->name("addQuestion");

    Route::resource("users","Admin\UserAdminController");
    Route::post("resetPasswordByAdmin","Admin\UserAdminController@resetPasswordByAdmin")->name("resetPasswordByAdmin");
    Route::post("affectTestToUser","Admin\UserAdminController@affectTestToUser")->name("affectTestToUser");
    Route::post("affectTestToGoupUsers","Admin\UserAdminController@affectTestToGoupUsers")->name("affectTestToGoupUsers");

    Route::get("ResultTests","Admin\QuizAdminController@ResultTests")->name("ResultTests");
    Route::get("CorrigerTest","Admin\QuizAdminController@CorrigerTest")->name("CorrigerTest");
    Route::post("CorrigerTestStore","Admin\QuizAdminController@CorrigerTestStore")->name("CorrigerTestStore");
    
    Route::resource("quizzes","Admin\QuizAdminController");
    Route::get("/Tests/{module}","Admin\QuizAdminController@getTestsByModule")->name("testsByModule");
});

Route::get("/test",function(){
    return PendingQuiz::all();
});

