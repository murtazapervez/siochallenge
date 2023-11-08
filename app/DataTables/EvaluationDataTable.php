<?php

namespace App\DataTables;

use App\Models\Evaluation;
use App\Models\Task;
use App\Models\Timelog;
use App\Repositories\TimeLogRepository;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Time;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EvaluationDataTable extends DataTable
{
    private $timeLogRepository;

    public function __construct(TimeLogRepository $timeLogRepository) {
        $this->timeLogRepository = $timeLogRepository;
    }
    
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'evaluation.action')
            ->addColumn('user_name', function(Timelog $timelog){
                return $timelog->user->name;
            })
            ->addColumn('user_name', function(Timelog $timelog){
                return $timelog->user->name;
            })
            ->rawColumns(['user_name','hours_worked'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Timelog $model): QueryBuilder
    {
        return Timelog::groupBy('user_id','id')->get()->toQuery();
        // return $model->newQuery();
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
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('id'),
            Column::make('user_name'),
            Column::make('hours_worked')
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
