@extends('layouts.admin')

@section('content')

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
    @error('user_reached')
    <div class="alert alert-danger">
        {{ $message }}
    </div>
    @enderror


    <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 40px;color:#4E73DF;">Users</h1>

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <x-access-link title="<i class='fa fa-plus'></i> Create" :href="route('users.create')"
                               class="btn btn-sm btn-primary" access="Editors Admin Control" />

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-bordered dataTable dt-responsive responsive w-100']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {!! $dataTable->scripts('', ['type' => 'module']) !!}

    <script type="module">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const table = $('#usersdatatable-table');
        table.on('preXhr.dt', function (e, settings, data) {
            data.first_name = $('#first_name').val();
            data.last_name = $('#last_name').val();
            data.second_name = $('#second_name').val();
            data.active = $('#job_titles_id').val();
            data.active = $('#active').val();
        });


        $('#first_name').on('change', function () {
            table.DataTable().ajax.reload();
        })

        $('#last_name').on('change', function () {
            table.DataTable().ajax.reload();
        });

        $('#second_name').on('change', function () {
            table.DataTable().ajax.reload();
        });

        $('#job_titles_id').on('change', function () {
            table.DataTable().ajax.reload();
        });

        $('#active').on('change', function () {
            table.DataTable().ajax.reload();
        });

        $(document).on('click', '.changeStatus', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');

            $.post(url, {}, function (data) {
                location.reload();
            }, 'json').fail(function(data) {
                bootbox.alert({
                    message: data.responseJSON.message,
                    className: 'rubberBand animated'
                });
            }, 'json');
        });

    </script>
@endpush
