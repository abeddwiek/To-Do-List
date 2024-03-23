<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function index(){
       $loggedUserInfo = Auth::user();
       $userOwnedTask = Task::where('creator_id',$loggedUserInfo->id)->get();
       $userAssignedTask = Task::where('assigned_user_id',$loggedUserInfo->id)->orderby('status_id')->get();


       return view('user.profile.index', [
           'information'=>$loggedUserInfo,
           'userOwnerTasks'=>$userOwnedTask,
           'userAssignedTask' =>$userAssignedTask,

       ]);

   }

    public function changeStatus(Request $request) {

       $notStartStatus = TaskStatus::where('name','Not Started')->first();
       $completeStatus = TaskStatus::where('name','Completed')->first();

        $task = Task::findorFail($request->assignedId);

        if($task->status_id == $notStartStatus->id){
            $task->status_id =  $completeStatus->id;
        }else{
            $task->status_id  = $notStartStatus->id;
        }
        $task->save();
        response()->json(['status' => 1]);

//
//        $task->status = TaskStatus::where('name','Completed')->get('id');
//        $task->save();
    }
}
