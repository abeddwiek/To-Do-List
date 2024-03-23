@extends('layouts.admin')

@section('content')

<h1 class="h3 mb-2 text-center font-weight-bold" style="font-size: 40px;color:#4E73DF;">Groups</h1>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"></h1>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <a href="{{route('groups.create')}}"class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Create</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!! $dataTable->table(['class' => 'table table-bordered dataTable  dt-responsive responsive w-100']) !!}
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

        $(document).on('click', '.deleteGroup', function(e){
            e.preventDefault();
            let id = $(this).data('id');

            bootbox.confirm({
                title: "Do you want delete this group?",
                message: "This will delete the group with all data.",
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
                        $.post('{{route('groups.destroy')}}', {'id' : id}, function(data){
                            location.reload();
                        }, 'json');
                    }
                }
            });
        });



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const table =$('#group-table');

        table.on('preXhr.dt',function(e,settings,data){
         data.name = $('#name').val();
         data.location_id = $('#location_id').val();

        });

        $('#location_id').on('change',function(){
            table.DataTable().ajax.reload();
        })


        $('#name').on('change',function(){
            table.DataTable().ajax.reload();
        });
</script>

@endpush
