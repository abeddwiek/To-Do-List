<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserHasTenant;
use App\Models\Tenant;
use App\Traits\CheckAuthTenant;
use Spatie\Permission\Models\Role;
use App\Models\ToDo;


class ToDos extends Component
{
    protected $listeners = ['taskAdded' => '$refresh'];

    public function render()
    {
        if(!auth()->user()->hasPermissionTo('To Do', 'tenants')){
            return redirect()->to(route('home'))->with('errorMessage',"you dont have Permission !");
        }
        $totalTasks = auth()->user()->AssignedUser()->count();
        $tasks = auth()->user()->AssignedUser()->latest()->get();
        return view('livewire.to-do', [
            'totalTasks' => $totalTasks,
            'tasks' => $tasks
        ]);

    }
}
