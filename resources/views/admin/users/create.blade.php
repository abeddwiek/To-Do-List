@extends('layouts.admin')

@section('content')



@if(session()->has('errorMessage'))
<div class="alert alert-danger">
    {{ session()->get('errorMessage') }}
</div>
@endif

@if(session()->has('errorMessage') && $data->id != 0)
<div class="alert alert-danger">
    {{ session()->get('errorMessage') }}
</div>
@endif

    <!-- Page Heading -->
    @if($data->id == 0)
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color: #4E73DF;">Create new user</h1>
    @else
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color:#4E73DF;"> Edit User
            "<a style="color: #f43f5e;" href="{{route('users.details', [$data->id])}}">{{$data->first_name}} {{$data->last_name}}</a>"</h1>
    @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <form class="g-3" method="post" action="{{route('users.store', ['user' => $data])}}">
                    @csrf
                    <div class="card mt-5">
                        <div class="card-header">
                            User Information
                        </div>
                        <div class="card-body">

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Nmae<span style="color: #f43f5e">*</span></label>
                            <input type="text" name="name" class="form-control" id="inputEmail4" value="{{old('name', $data->name)}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Email<span style="color: #f43f5e">*</span></label>
                            <input type="text"name="email" class="form-control" id="inputEmail4"  value="{{old('email', $data->email)}}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>



                    </div>

                    @if (is_null($data->id))
                    <div class="row mt-2">

                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Password
                                <span style="color: #f43f5e">*</span></label>
                            <input type="password" name="password" class="form-control" id="inputPassword"  value="" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="inputEmail4"  value=""required>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                    </div>
                    @endif

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

@push('scripts')

<script type="module">

    // $(document).ready(function(){
    //         $('#expiry_date').datepicker({
    //             format: 'yyyy-mm-dd',
    //             date: new Date(),
    //         });
    //     })
</script>

@endpush
