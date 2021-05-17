<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAdminController extends Controller
{
    public function changePasswordForm(){
        return view("auth.passwords.reset");
    }

    public function resetPasswordByAdmin(Request $request){
        $user=User::findOrfail($request->user_id);
        //Hash::make();
        $newPassword =Str::random(8);
        $user->password=Hash::make($newPassword);
        $user->password_reseted=1;
        $user->save();
        return back()->with("message"," mot de passe réinitialisé avec succès pour ".$user->name."\n mot de passe : ".$newPassword);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where("role_id","=",2)->get()->each(function($user){
            $user->role=$user->role()->first()->name;
            $user->grade=$user->grade()->first()->name;
        });
        $tests = Quiz::all()->sortByDesc('created_at');
        return view("admin.users.index",["users"=>$users,"tests"=>$tests]);
    }

    public function affectTestToUser(Request $request){
        $quiz =Quiz::find($request->test_id);
        $user = User::find($request->user_id);
        $this->testToUser($quiz,$user);
        return back()->with("message","le test ".$quiz->title." est affecté à ".$user->name." avec succès");
    }

    function testToUser(Quiz $quiz,User $user){
        $test=$user->quizzes()->where("id","=",$quiz->id)->first();
        if($test){
            $test->pivot->score=null;
            $test->pivot->correctQuestions=null;
            $test->pivot->opened=null;
            $test->pivot->isAdminCorrection=null;
            $test->pivot->save();
        }else{
            $user->quizzes()->attach($quiz->id);
        }
        
    }

    public function affectTestToGoupUsers(Request $request){
        $quiz=Quiz::find($request->test_id);
        $users=User::where("role_id","=",2)->whereIn("grade_id",[$request->PO,$request->CDB,$request->INST])->get();
        $users->each(function  ($user) use ($quiz) {
            $this->testToUser($quiz,$user);
        });
        return back()->with("message","le test ".$quiz->title." est affecté aux groupes avec succès");

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
