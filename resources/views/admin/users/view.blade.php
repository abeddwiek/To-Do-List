@extends('layouts.admin')

@section('content')



@if(session()->has('errorMessage'))
<div class="alert alert-danger">
    {{ session()->get('errorMessage') }}
</div>
@endif


  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color:#4E73DF;">User details for "<span
              style="color: #f43f5e;">{{$userData->first_name}} {{$userData->last_name}}</span>"</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">

          <x-access-link title="<i class='fa fa-edit'></i> Edit" :href="route('users.edit', ['user' => $userData->id])"
            class="btn btn-sm btn-primary" access="Editors Admin Control" />

         </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-4">
                    <x-card title="User Details" id="user_details">
                        <div class="row">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>Name</td>
                                    <td>{{$userData->getFullName()}}</td>
                                </tr>
                                <tr>
                                    <td>Mobile Number</td>
                                    <td>{{$userData->mobile_number}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$userData->email}}</td>
                                </tr>
                                <tr>
                                    <td>Groups</td>
                                    <td>
                                        <ul>
                                            @foreach($userData->groups as $group)
                                                    <li>{{$group->name}}</li>
                                                @endforeach
                                        </ul>

                                    </td>
                                </tr>


                            </table>
                        </div>
                    </x-card>
                </div>

            </div>
        </div>
    </div>


@endsection
