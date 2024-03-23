@extends('layouts.admin')

@section('content')
     <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 40px;color: #4E73DF;"></h1>
    @if(session()->has('errorMessage'))
        <div class="alert alert-danger">
            {{ session()->get('errorMessage') }}
        </div>
    @endif
    @if($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <strong>{{ $message }}</strong>
</div>
@endif


    <div class="container-fluid">
    <div class="row justify-content-center">
    </div>
</div>





@endsection
@push('scripts')


@endpush
