<?php

namespace App\Http\Controllers;

use App\DataTables\GroupDataTable;
use App\Models\Group;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GroupDataTable $dataTable)
    {
        if (!auth()->user()->hasPermissionTo('User', 'tenants')) {
            return redirect()->to(route('home'))->with('errorMessage', "you dont have Permission !");
        }

        $group = Group::all();

		return $dataTable->render('admin.groups.index',['group'=>$group]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        if (!auth()->user()->hasPermissionTo('User', 'tenants')) {
            return redirect()->to(route('home'))->with('errorMessage', "you dont have Permission !");
        }

		$users = User::all();


		return view('admin.groups.create', ['data' => $group, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Group $group, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_ids' => 'nullable|array',
        ]);

        $group->user_id = auth()->user()->id;
        $group->tenant_id = auth()->user()->tenant->id;
        $group->name =$request->get('name');
        $group->save();


        UserGroup::where('group_id', $group->id)->delete();
        if($request->has('user_ids')) {
            $userIds = $request->get('user_ids');
            foreach($userIds as $key=>$userId){
               $userGroup = new UserGroup();
               $userGroup->group_id = $group->id;
               $userGroup->user_id = $userId;
               $userGroup->save();
            }
        }

        return redirect(route('groups.index'))->with('message', 'group saved!');
    }


    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required']);
        $group =Group::find($request->id);
        $group->delete();

        return response()->json(['status' => 1]);
    }
}
