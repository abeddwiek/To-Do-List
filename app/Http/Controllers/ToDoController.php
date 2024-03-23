<?php

namespace App\Http\Controllers;


use App\Models\ToDo;
use App\Models\User;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function index()
    {
        if(!auth()->user()->hasPermissionTo('To Do', 'tenants')){
            return redirect()->to(route('home'))->with('errorMessage',"you dont have Permission !");
        }

        $assignedUsers = User::all();
        $statuses=['0'=>'Completed','1'=>'Not Completed'];

        return view('admin.todos.index', compact(['assignedUsers', 'statuses']));

    }

    public function create_edit( )
    {


    }


    public function details()
    {



    }

    public function store(Request $request)
    {
    }

    public function storeAssignedUser(Request $request)
    {

    }

}
