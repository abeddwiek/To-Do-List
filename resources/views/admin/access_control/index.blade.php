@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 40px;color: #4E73DF;">Access Control</h1>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    @if(session()->has('errorMessage'))
        <div class="alert alert-danger">
            {{ session()->get('errorMessage') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @foreach($permissionGroup as $group)
                        <div class="accordion" id="accordion{{$group->id}}">

                            <div class="card">
                                <div class="card-header" id="heading{{$group->id}}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapse{{$group->id}}"
                                                aria-expanded="true" aria-controls="collapse{{$group->id}}">
                                            {{$group->name}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse{{$group->id}}" class="collapse"
                                     aria-labelledby="heading{{$group->id}}" data-parent="#accordion{{$group->id}}">
                                    <div class="card-body">
                                        <table class="table table-bordered table-primary">
                                            @foreach($group->Children as $child)
                                            <tr>
                                                <td>{{$child->name}}</td>
                                                <td width="200"><a class="btn btn-primary btn-sm accessModal" data-title="{{$child->name}}" data-id="{{$child->id}}">Edit Access Control</a></td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="accessModal" tabindex="-1" role="dialog" aria-labelledby="accessModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessModalLabel">Access Control</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="permission_group_id" value="" />
                    <div class="accordion" id="accordionAccessGroupReaders">
                        <div class="card">
                            <div class="card-header" id="headingAccessGroupReaders">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseAccessGroupReaders"
                                            aria-expanded="true" aria-controls="collapseAccessGroupReaders">
                                        Readers
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseAccessGroupReaders" class="collapse"
                                 aria-labelledby="headingAccessGroupReaders" data-parent="#accordionAccessGroupReaders">
                                <div class="card-body">
                                    <table class="table table-bordered table-primary">
                                        <select class="select2-readers" name="readers[]" multiple="multiple">

                                        </select>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion" id="accordionAccessGroupEditors">
                        <div class="card">
                            <div class="card-header" id="headingAccessGroupEditors">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseAccessGroupEditors"
                                            aria-expanded="true" aria-controls="collapseAccessGroupEditors">
                                        Editors
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseAccessGroupEditors" class="collapse"
                                 aria-labelledby="headingAccessGroupEditors" data-parent="#accordionAccessGroupEditors">
                                <div class="card-body">
                                    <table class="table table-bordered table-primary">
                                        <select class="select2-editors" name="editors[]" multiple="multiple">

                                        </select>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion" id="accordionAccessGroupManagers">
                        <div class="card">
                            <div class="card-header" id="headingAccessGroupManagers">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseAccessGroupManagers"
                                            aria-expanded="true" aria-controls="collapseAccessGroupManagers">
                                        Managers
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseAccessGroupManagers" class="collapse"
                                 aria-labelledby="headingAccessGroupManagers" data-parent="#accordionAccessGroupManagers">
                                <div class="card-body">
                                    <table class="table table-bordered table-primary">
                                        <select class="select2-managers" name="managers[]" multiple="multiple">

                                        </select>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-access-control">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script type="module">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.accessModal', function(e){
            e.preventDefault();
            var permission_group_id = $(this).data('id');
            $('.select2-readers').val(null).trigger("change");
            $('.select2-editors').val(null).trigger("change");
            $('.select2-managers').val(null).trigger("change");
            $('.select2-readers').empty().trigger("change");
            $('.select2-editors').empty().trigger("change");
            $('.select2-managers').empty().trigger("change");
            $.get('{{route('access-control.get-users-and-groups')}}', {'id' : permission_group_id}, function($data){
                var users = [];
                var groups = [];
                $.each($data.users, function(i, v){
                    users.push({'id' : 'user_' + v.id, 'text' : v.first_name + ' ' + v.last_name});
                });
                $.each($data.groups, function(i, v){
                    groups.push({'id' : 'group_' + v.id, 'text' : v.name});
                });

                var data = [{'text' : 'Users', 'children' : users},
                    {'text' : 'Groups', 'children' : groups},
                ]

                $('.select2-readers').select2({'data' : data});
                $('.select2-editors').select2({'data' : data});
                $('.select2-managers').select2({'data' : data});

                var selected_readers = [];
                var selected_editors = [];
                var selected_managers = [];
                $.each($data.selected.Readers.users, function(i, v){
                    selected_readers.push('user_' + v);
                });

                $.each($data.selected.Readers.groups, function(i, v){
                    selected_readers.push('group_' + v);
                });

                $.each($data.selected.Editors.users, function(i, v){
                    selected_editors.push('user_' + v);
                });

                $.each($data.selected.Editors.groups, function(i, v){
                    selected_editors.push('group_' + v);
                });

                $.each($data.selected.Managers.users, function(i, v){
                    selected_managers.push('user_' + v);
                });

                $.each($data.selected.Managers.groups, function(i, v){
                    selected_managers.push('group_' + v);
                });

                $('.select2-readers').val(selected_readers).trigger('change');
                $('.select2-editors').val(selected_editors).trigger('change');
                $('.select2-managers').val(selected_managers).trigger('change');
                $('#accessModal').find('input[name=permission_group_id]').val(permission_group_id);
                $('#accessModal').modal("show");
            }, 'json')

        });

        $(document).on('click', '.save-access-control', function(e) {
            e.preventDefault();
            var permission_group_id = $(this).closest('.modal').find('input[name=permission_group_id]').val();
            var permission_readers = $('.select2-readers').val();
            var permission_editors = $('.select2-editors').val();
            var permission_managers = $('.select2-managers').val();

            $.post("{{route('access-control.store')}}", {'id' : permission_group_id, 'permission_readers' : permission_readers, 'permission_editors' : permission_editors, 'permission_managers' : permission_managers}, function($data){
                $('#accessModal').modal("hide");
            }, 'json');

        });


    </script>
@endpush
