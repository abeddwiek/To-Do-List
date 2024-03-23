<?php

namespace App\Http\Controllers;

use App\DataTables\AccessControlDataTableDataTable;
use App\Models\Group;
use App\Models\ModelHasPermission;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Http\Request;

class AccessControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->hasAnyRole(['Admin', 'Managers'])){
            return redirect()->to(route('home'))->with('errorMessage',"you dont have Permission !");
        }

        $permissionGroup = PermissionGroup::whereNull('parent_id')->get();
        $users = User::query()->get();
        $groups = Group::all();

        return view('admin.access_control.index', ['permissionGroup' => $permissionGroup, 'users' => $users, 'groups' => $groups]);
    }

    public function getUsersAndGroups(Request $request)
    {
        $request->validate(['id' => 'required|exists:permission_groups,id']);

        $users = User::query()->get();
        $groups = Group::all();

        $permissionGroup = PermissionGroup::find($request->get('id'));
        $permissions = $permissionGroup->permissions;

        $selectedUsersAndGroups = [];
        foreach($permissions as $permission) {

            $selectedUsers = ModelHasPermission::where('model_type', User::class)->where('permission_id', $permission->id)->pluck('model_id')->toArray();
            $selectedGroups = ModelHasPermission::where('model_type', Group::class)->where('permission_id', $permission->id)->pluck('model_id')->toArray();

            $selectedUsersAndGroups[$permission->name] = ['users' => $selectedUsers, 'groups' => $selectedGroups];
        }

        $response = ['users' => $users, 'groups' => $groups, 'selected' => $selectedUsersAndGroups];

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate(['id' => 'required|exists:permission_groups,id']);
        $permissionGroup = PermissionGroup::find($request->get('id'));
        $permissions = $permissionGroup->permissions;

        $permission = Permission::where('group_id', $permissionGroup->id)->where('name', 'Readers')->first();
        if(!$permission) {
            $permission = new Permission();
            $permission->name = 'Readers';
            $permission->group_id = $permissionGroup->id;
            $permission->guard_name = 'web';
            $permission->save();
        }

        ModelHasPermission::where('permission_id', $permission->id)->delete();

        if($request->has('permission_readers')) {
            $permissionReaders = $request->get('permission_readers');
            foreach($permissionReaders as $item) {
                if(str_contains($item, 'user_')) {
                    $item = str_replace('user_', '', $item);
                    $modelHasPermission = new ModelHasPermission();
                    $modelHasPermission->model_type = User::class;
                    $modelHasPermission->model_id = $item;
                    $modelHasPermission->permission_id = $permission->id;
                    $modelHasPermission->save();
                }

                if(str_contains($item, 'group_')) {
                    $item = str_replace('group_', '', $item);
                    $modelHasPermission = new ModelHasPermission();
                    $modelHasPermission->model_type = Group::class;
                    $modelHasPermission->model_id = $item;
                    $modelHasPermission->permission_id = $permission->id;
                    $modelHasPermission->save();
                }
            }
        }

        //editors
        $permission = Permission::where('group_id', $permissionGroup->id)->where('name', 'Editors')->first();
        if(!$permission) {
            $permission = new Permission();
            $permission->name = 'Editors';
            $permission->group_id = $permissionGroup->id;
            $permission->guard_name = 'web';
            $permission->save();
        }

        ModelHasPermission::where('permission_id', $permission->id)->delete();

        if($request->has('permission_editors')) {
            $permissionEditors = $request->get('permission_editors');
            foreach($permissionEditors as $item) {
                if(str_contains($item, 'user_')) {
                    $item = str_replace('user_', '', $item);
                    $modelHasPermission = new ModelHasPermission();
                    $modelHasPermission->model_type = User::class;
                    $modelHasPermission->model_id = $item;
                    $modelHasPermission->permission_id = $permission->id;
                    $modelHasPermission->save();
                }

                if(str_contains($item, 'group_')) {
                    $item = str_replace('group_', '', $item);
                    $modelHasPermission = new ModelHasPermission();
                    $modelHasPermission->model_type = Group::class;
                    $modelHasPermission->model_id = $item;
                    $modelHasPermission->permission_id = $permission->id;
                    $modelHasPermission->save();
                }
            }
        }

        //Managers
        $permission = Permission::where('group_id', $permissionGroup->id)->where('name', 'Managers')->first();
        if(!$permission) {
            $permission = new Permission();
            $permission->name = 'Managers';
            $permission->group_id = $permissionGroup->id;
            $permission->guard_name = 'web';
            $permission->save();
        }

        ModelHasPermission::where('permission_id', $permission->id)->delete();

        if($request->has('permission_managers')) {
            $permissionManagers = $request->get('permission_managers');
            foreach($permissionManagers as $item) {
                if(str_contains($item, 'user_')) {
                    $item = str_replace('user_', '', $item);
                    $modelHasPermission = new ModelHasPermission();
                    $modelHasPermission->model_type = User::class;
                    $modelHasPermission->model_id = $item;
                    $modelHasPermission->permission_id = $permission->id;
                    $modelHasPermission->save();
                }

                if(str_contains($item, 'group_')) {
                    $item = str_replace('group_', '', $item);
                    $modelHasPermission = new ModelHasPermission();
                    $modelHasPermission->model_type = Group::class;
                    $modelHasPermission->model_id = $item;
                    $modelHasPermission->permission_id = $permission->id;
                    $modelHasPermission->save();
                }
            }
        }


        return response()->json(['status' => 1]);
    }
}
