<?php

namespace App\DataTables;

use App\Models\User;
use App\Scopes\TenantScope;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($data){
                return view('admin.users.action', ['data' => $data])->render();
            });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UsersDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model,Request $request)
    {
        $query = $model->newQuery();

        if(!auth()->user()->hasRole('Admin')){
            // need to fix on edit user repeation
            return  $query->where('tenant_id', auth()->user()->tenant_id);
        }else{
            if(request()->has('tenantID')) {
                return  $query->where('tenant_id', request()->tenantID)->withoutGlobalScope(TenantScope::class);
            }else{
                return  $query->where('tenant_id', auth()->user()->tenant_id);
            }

        }

        $first_name =$request->get('name');
        $status = $request->get('active');

        return $query;

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return     $this->builder()
                    ->setTableId('usersdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('users.index'))
                   ->dom('ltipr')
                    ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('id'),
            Column::make('name')->title('First Name'),
            Column::make('active')->title('Disabled')->type('yes_no'),
            Column::make('email'),
            Column::make('created_at')->type('date'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->responsivePriority(0),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
