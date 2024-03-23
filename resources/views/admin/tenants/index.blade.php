@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 40px;color: #4E73DF;">Tenant</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <a href="{{route('tenants.edit')}}"class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Create</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'tenants-table table table-bordered dataTable dt-responsive responsive w-100']) !!}
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

        $(document).on('click', '.deleteTenant', function(e){
            e.preventDefault();
            let id = $(this).data('id');

            bootbox.confirm({
                title: "Do you want delete this tenant?",
                message: "This will delete the tenant with all data.",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if(result)
                    {
                        $.post('{{route('tenants.destroy')}}', {'id' : id}, function(data){
                            location.reload();
                        }, 'json');
                    }
                }
            });
        });
    </script>
@endpush
