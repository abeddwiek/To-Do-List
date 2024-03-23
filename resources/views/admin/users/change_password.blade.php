@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    @if($user->id == 0)
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color: #4E73DF;">Create new user</h1>
    @else
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color:#4E73DF;"> Edit usage unit
            "<a style="color: #f43f5e;" href="{{route('users.details', [$user->id])}}">{{$user->name}}</a>"</h1>
    @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <form class="g-3" method="post" action="{{route('users.store_password', ['user' => $user])}}">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword"  value="">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="inputEmail4"  value="">
                            @error('password_confirmation')
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

@push('scripts')

@endpush
