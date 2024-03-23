@extends('layouts.auth')

@section('content')

                        <div class="p-5">
                            <div class="text-center mb-4">
                            <img src="{{asset('img/checklist-1295319_640.png')}}" class="my-auto" style="width:50%; " />
                        </div>
                        <form class="user" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email"
                                       id="exampleInputEmail" aria-describedby="emailHelp"
                                       placeholder="Enter Email Address...">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" name="password"
                                       id="exampleInputPassword" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" >
                                    <label class="custom-control-label" for="customCheck">Remember
                                        Me</label>
                                </div>
                            </div>

                            <button class="btn btn- btn-user btn-block " style=" background-color: #525252; /* Green */
                            border: none;
                            color: white;
                            text-align: center;
                            text-decoration: none;
                            display: block;
                            font-size: 16px;
                            width: 40%;
                            Margin: auto;
                                                 ">
                                Login
                            </button>
                            <hr>
                        </form>
                        <hr>
                        @if (Route::has('password.request'))
                        <div class="text-center">
                            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        @endif
                    </div>



@endsection
