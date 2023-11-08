<?php

namespace App\DataTables;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TaskDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('action', function (Task $task) {
                $viewRoute = route('task.edit', $task->id);

                return "<a href=\"{$viewRoute}\" class=\"btn btn-primary m-2\">View</a>";
            })
            ->addColumn('project_name', function (Task $task) {
                $viewRoute = route('project.edit', $task->project_id);

                return "<a href=\"{$viewRoute}\">{$task->project->title}</a>";
            })
            ->addColumn('time', function (Task $task) {
                $totalHours = 0;

                foreach ($task->logs as $timelog) {
                    $start = Carbon::parse($timelog->start_time);
                    $end = Carbon::parse($timelog->end_time);

                    $hours = $end->diffInHours($start);
                    $totalHours += $hours;
                }
                return $totalHours . ' Hrs';
            })
            ->editColumn('created_at', function (Task $task) {
                return Carbon::parse($task->created_at)->format('Y-m-d H:i:s');
            })
            ->rawColumns(['action', 'project_name', 'time'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Task $model): QueryBuilder
    {
        // Filter the query based on the provided 'id' parameter
        if ($this->id) {
            return $model->newQuery()->where('project_id', $this->id);
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('task-table')
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
            Column::make('project_name'),
            Column::make('time'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Task_' . date('YmdHis');
    }
}
