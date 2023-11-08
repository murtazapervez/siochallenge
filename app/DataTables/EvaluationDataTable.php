<?php

namespace App\DataTables;

use App\Models\Evaluation;
use App\Models\Task;
use App\Models\Timelog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EvaluationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user_name',function(Timelog $timelog){
                return $timelog->user->name; 
            })
            // ->editColumn('hours/_week',function(Task $task){

            //     $totalHours = 0;

            //     foreach ($task->logs as $timelog) {
            //         $start = Carbon::parse($timelog->start_time);
            //         $end = Carbon::parse($timelog->end_time);

            //         $hours = $end->diffInHours($start);
            //         $totalHours += $hours;
            //     }
            //     return $totalHours . ' Hrs';
            //     return 
            //  })
            // ->editColumn('hours/_month',function(Task $task){
            //     return true; 
            //  })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Timelog $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('evaluation-table')
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
            Column::make('user_name'),
            // Column::make('hours/_week'),
            // Column::make('hours/_month'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Evaluation_' . date('YmdHis');
    }
}
