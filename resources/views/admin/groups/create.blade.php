@extends('layouts.admin')

@section('content')
    @if (session()->has('errorMessage'))
        <div class="alert alert-danger">
            {{ session()->get('errorMessage') }}
        </div>
    @endif



    <!-- Page Heading -->
    @if ($data->id == 0)
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color: #4E73DF;">Create new Group</h1>
    @else
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color:#4E73DF;"> Edit Group
            "<span style="color: #f43f5e;">{{ $data->name }}</span>"</h1>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <form class="g-3" method="post" action="{{ route('groups.store', ['group' => $data]) }}" enctype="multipart/form-data">
                    @csrf
                    @if ($data->id)
                        <input type="hidden" name="id" value="{{ $data->id }}" />
                    @endif
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Name
                                <span style="color: #f43f5e">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" id="inputEmail4"
                                value="{{ old('name', $data->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-8 mt-2">
                            <label for="inputEmail4" class="form-label">Users</label>
                            <select name="user_ids[]" class="form-control justify-content-center"  size="10" style="display: flex;" id="assigned_user" multiple>
                                 @foreach ($users as $option)
                                    <option value="{{$option->id}}"
                                        {{in_array($option->id , old('user_ids', $data->users->pluck('id')->toArray()))? 'selected' : ''}}
                                    >{{$option->name}}</option>

                                @endforeach
                            </select>
                            @error('user_ids')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



