@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 p-4">
            @livewire('AddToDos')

        </div>

        <div class="col-md-8 p-4">

            @livewire('ToDos')


        </div>
    </div>
</div>
@endsection
