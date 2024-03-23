@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    @if($data->id == 0)
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color: #4E73DF;">Create Tenant</h1>
    @else
        <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 25px;color:#4E73DF;"> Edit Tenant
            "<span style="color: #f43f5e;">{{$data->name}}</span>"</h1>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">

                <form class="g-3" method="post" action="{{route('tenants.store', ['tenant' => $data])}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card mt-5">
                        <div class="card-header d-flex justify-content-between">
                            Basic Information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="inputEmail4" class="form-label">ID <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="idreadonly" class="form-control" id="name"
                                           value="@if($data->id) {{$data->id}} @else Auto generated @endif" readonly>
                                    @error('idreadonly')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="inputEmail4" class="form-label">Tenant name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           value="{{old('name', $data->name)}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            @if(auth()->user()->hasRole('Admin'))
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="number_of_users" class="form-label">Active User Limit<span
                                            class="text-danger">*</span></label>
                                        <input type="number" name="number_of_users" min="1" class="form-control"
                                               id="number_of_users"
                                               value="{{old('number_of_users', $data->number_of_users)}}">
                                        @error('number_of_users')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="primary_email" class="form-label">Email<span
                                            class="text-danger">*</span></label>
                                        <input type="text" name="primary_email"  class="form-control"
                                               value="{{old('primary_email', $data->primary_email)}}">
                                        @error('primary_email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                </div>
                            @endif
                            <div class="row mb-4 mt-2">
                                <div class="col-md-12">
                                    <label for="inputEmail4" class="form-label">Note</label>
                                    <textarea class="form-control"
                                              name="description">{{old('name', $data->description)}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">

                            </div>

                            @if(auth()->user()->hasRole('Admin'))
                                <div class="row">
                                    <div class="col-md-2  my-1">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                                   name="lock"
                                                   value="1" {{!empty(old('lock', $data->lock)) && old('lock', $data->lock) == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="exampleCheck1">Active</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row  mt-5">
                                    @foreach ($permissionGroups as $group)
                                        <div class="col-4">
                                            <div class="card mt-4">
                                                <div class="card-header d-flex justify-content-between">
                                                    {{$group->name}}
                                                    <div class="card-header-pills">
                                                        <input type="checkbox" class="form-check-input" id="Groupcheck{{$group->id}}"
                                                               name="selectAll[{{$group->id}}]"
                                                               @if(old('selectAll') && is_array(old('selectAll'))) @if(in_array($group->id,old('selectAll'))) checked @endif @endif
                                                               value="{{$group->id}}"> Select All
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @foreach($group->permissions as $permission)

                                                    <div class="col-md-12  my-1">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="Checkbox{{$permission->id}}"
                                                               name="permissions[{{$permission->id}}]"
                                                                   value="{{$permission->name}}"
                                                                   @if($data->hasPermissionTo($permission->name, 'tenants')) checked  @endif
                                                                   @if(old('permissions') && is_array(old('permissions'))) @if(in_array($permission->name,old('permissions'))) checked @endif @endif
                                                                   >



                                                            <label class="form-check-label" for="Checkbox{{$permission->id}}">{{$permission->name}}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{--
                                  @foreach($permissions as $permission)
                                      @if(auth()->user()->hasPermissionTo($permission->name, 'tenants'))
                                          <div class="col-md-2  my-1">
                                              <div class="form-check">
                                                  <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                                         name="permissions[{{$permission->id}}]"
                                                         value="1" {{!empty(old('permissions.'.$permission->id, $data->permissions->where('name', $permission->name)->count() > 0)) && old('permissions.'.$permission->id, $data->permissions->where('name', $permission->name)->count() > 0) == 1 ? 'checked' : ''}}>
                                                  <label class="form-check-label"
                                                         for="exampleCheck1">{{$permission->name}}</label>
                                              </div>
                                          </div>
                                      @endif
                                  @endforeach--}}





                                <hr class="sidebar-divider my-10">
                            @endif

                            <div class="row mt-5">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script >

        $(document).on('change', 'input[name*=selectAll]', function(e){
            if($(this).is(':checked')) {
                $(this).closest('.card').find('input[type=checkbox]').prop('checked', true);
            }else{
                $(this).closest('.card').find('input[type=checkbox]').prop('checked', false);
            }
        })



        // $(document).on('change', 'input[name="end_date"]', function(e){
        //     e.preventDefault();
        //     var end_date = $(this).val();
        //     var $date = new Date();
        //     if(end_date > $date) {
        //         $('input[name="lock"]').prop('checked', false);
        //     }else{
        //         $('input[name="lock"]').prop('checked', true);
        //     }
        // });

    </script>

@endpush
