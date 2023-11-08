<?php

namespace App\DataTables;

use App\Models\Timelog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TimelogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function(Timelog $timelog){
                $viewRoute = route('timelog.edit', $timelog->id);
                $deleteRoute = route('timelog.delete', $timelog->task_id);

                return "<a href=\"{$viewRoute}\" class=\"btn btn-primary m-2\">View</a>
                
                <form action=\"{$deleteRoute}\" method='delete'>
                    <button type='submit' class=\"btn btn-danger m-2\">Delete</button> 
                </form>"; ##Has to fix the the delete function
            })
            ->editColumn('user_name', function(Timelog $timelog){
                return $timelog->user->name;
            })
            ->editColumn('task_name', function(Timelog $timelog){
                return $timelog->task->task_name;
            })
            ->editColumn('created_at', function(Timelog $timelog){
                return Carbon::parse($timelog->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('worked', function(Timelog $timelog){

                $start = Carbon::parse($timelog->start_time);
                $end = Carbon::parse($timelog->end_time);

                $hours = $end->diffInHours($start);
                return $hours . ' Hrs';
            })
            ->rawColumns(['user_name','action','task_name'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Timelog $model): QueryBuilder
    {
         // Filter the query based on the provided 'id' parameter
         if ($this->id) {
            return $model->newQuery()->where('task_id', $this->id);
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('timelog-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('task_name'),
            Column::make('user_name'),
            Column::make('start_time'),
            Column::make('end_time'),
            Column::make('worked'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Timelog_' . date('YmdHis');
    }
}
