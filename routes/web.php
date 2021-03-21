<?php

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


Route::group(["as"=>"user.","middleware"=>['auth','userRole']],function(){
  
    Route::get('home', function(){
        return view('user.index');
    })->name('home');

    //Route::get('cours',"coursController@index")->name('cours');
    Route::resource("cours","coursController");
    Route::resource("quizzes","quizController");
    
});


Route::group(["as"=>"admin.","prefix"=>"admin","middleware"=>['auth','adminRole']],function(){
  
    Route::get('home', function(){
        return view('admin.index');
    })->name('home');
    
});