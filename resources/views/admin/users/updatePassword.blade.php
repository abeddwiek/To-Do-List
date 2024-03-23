@extends('layouts.admin')

@section('content')


@if(session()->has('errorMessage') && $data->id != null )
<div class="alert alert-danger">
    {{ session()->get('errorMessage') }}
</div>
@endif



    <!-- Page Heading -->
    @if($data->id != null )

        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color:#4E73DF;"> Edit Password
            "<a style="color: #f43f5e;" href="{{route('users.details', [$data->id])}}">{{$data->first_name}} {{$data->last_name}}</a>"</h1>
    @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <form class="g-3" method="post" action="{{route('users.editPassword')}}">
                    @csrf
                    @if($data->id)
                        <input type="hidden" name="id" value="{{$data->id}}" />
                    @endif

                    @if ($data->id != null)
                        <div class="row mb-4">

                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Password <span style="color: #f43f5e">*</span></label>
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
                    @endif

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
