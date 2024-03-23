<?php

namespace App\Livewire;

use Livewire\Component;

class AddToDos extends Component
{
    public $title;
    public function render()
    {
        return view('livewire.add-to-dos');
    }
    public function addTask()
    {

        auth()->user()->AssignedUser()->create([
            'subject' => $this->title,
            'creator_id' => auth()->user()->id,
            'status' => false,
        ]);

        $this->title = "";

        //$this->emit('taskAdded');
    }
}
