<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserHasTenant;
use App\Models\Tenant;
use App\Traits\CheckAuthTenant;
use Spatie\Permission\Models\Role;
use App\Models\ToDo;

class ToDoController extends Controller
{
    public function index()
    {
        // check user hasPermissionTo
        if(!request()->user()->hasPermissionTo('To Do', 'tenants')){
            array_push($errors, ['code' => 'Permission', 'message' => 'you dont have Permission']);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
         $tasks = request()->user()->AssignedUser()->latest()->get();
        if(!$tasks){
            return response()->json($tasks,200);
                }else{

                  return response()->json(['message' => 'No such data found!'], 404);

                }
    }

    public function add(Request $request)
    {
        //// check user hasPermissionTo
        if(!request()->user()->hasPermissionTo('To Do', 'tenants')){
            array_push($errors, ['code' => 'Permission', 'message' => 'you dont have Permission']);
            return response()->json([
                'errors' => $errors
            ], 403);
        }

      // validate from request
        $request->validate([
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        try {
            $task = request()->user()->AssignedUser()->create([
                'subject' => $request->subject,
                'creator_id' => request()->user()->id,
                'status' => false,
            ]);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }

           return response()->json($task,200);

    }
}



