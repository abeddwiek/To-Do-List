<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\ModelHasTenant;
use App\Models\Provider;
use App\Models\User;
use App\Models\UserHasTenant;
use App\Models\Tenant;
use App\Traits\CheckAuthTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public $tenantLimit = 0;

    public function index(UsersDataTable $dataTable)
    {
        if (!auth()->user()->hasPermissionTo('User', 'tenants')) {
            return redirect()->to(route('home'))->with('errorMessage', "you dont have Permission !");
        }

        $users = User::all();


        return $dataTable->render('admin.users.users', [
            'users' => $users,
        ]);
    }

    public function create(User $user)
    {

        if (!auth()->user()->hasPermissionTo('User', 'tenants')) {
            return redirect()->to(route('home'))->with('errorMessage', "you dont have Permission !");
        }



        $roles = Role::where('name', '!=', 'Admin')->get();
        return view('admin.users.create', ['data' => $user]);
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);


        $user->fill($request->all());

        if($request->has('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();



        return redirect(route('users.index'))->with('message', 'User saved!');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view($id)
    {

        if (!auth()->user()->hasPermissionTo('User', 'tenants')) {
            return redirect()->to(route('home'))->with('errorMessage', "you dont have Permission !");
        }

        $users = User::findOrNew($id);
        return view('admin.users.view', ['userData' => $users]);
    }

    public function changePassword(User $user)
    {
        return view('admin.users.change_password', ['user' => $user]);
    }


    public function showEditPassword($id, Request $request)
    {
        if (!auth()->user()->hasPermissionTo('User', 'tenants') && $id != 0) {
            return redirect()->to(route('home'))->with('errorMessage', "you dont have Permission !");
        }

        $users = User::findOrNew($id);
        return view('admin.users.updatePassword', ['data' => $users]);


    }

    public function editPassword(Request $request)
    {

        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $password = $request->get('password');

        $id = 0;
        if ($request->has('id') && $request->get('id') != '') {
            $id = $request->get('id');
        }

        $user = User::findOrNew($request->get('id'));

        if ($user->id != '1' && $password != '') {
            $user->password = Hash::make($password);
        }

        $user->save();

        return redirect(route('users.index'))->with('message', 'User saved!');

    }

    public function changeStatus(Request $request, User $user)
    {

        $user->active = $user->active ? 0 : 1;
        $user->save();
        return response()->json(['data' => $user]);
    }
}
