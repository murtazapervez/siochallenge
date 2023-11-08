<?php

use App\DataTables\EvaluationDataTable;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeLogController;
use App\Interfaces\TimeLogRepositoryInterface;
use App\Models\Timelog;
use App\Repositories\TimeLogRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Type\Time;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(ProjectController::class)
    ->name('project.')
    ->prefix('project')
    ->group(function () {
        Route::get('/', 'index')->name('index');

        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        Route::get('/edit/{project}', 'edit')->name('edit');
        Route::put('/{project}', 'update')->name('update');
    });


Route::controller(TaskController::class)
    ->name('task.')
    ->prefix('task')
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        Route::get('/edit/{task}', 'edit')->name('edit');
        Route::put('/{task}', 'update')->name('update');
        // Route::delete('/{task}', 'destroy')->name('delete');

    });


Route::controller(TimeLogController::class)
    ->name('timelog.')
    ->prefix('timelog')
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        Route::get('/edit/{timelog}', 'edit')->name('edit');
        Route::put('/{timelog}', 'update')->name('update');
        Route::delete('/{timelog}', 'destroy')->name('delete');
    });



/**
 * In this example I'm implementing datatable using another technique without using datatables
 * Using dependency injection
*/


Route::get('/evaluation', function (TimeLogRepository $timeLogRepository) {


    if (request()->ajax()) {
        $data = $timeLogRepository->getEvaluationStats();
        
        return Datatables::of($data->get())
                    ->addIndexColumn()
                    ->addColumn('username',function($data){
                        return $data->user->name;
                    })
                    ->addColumn('total_time_spent_in_hours',function($data){
                        $val = $data->total_time_spent_in_hours . " Hrs";
                        return  $val;
                    })
                    ->rawColumns(['username', 'total_time_spent_in_hours'])
                    ->make(true);
        // return response()->json($data);
    }
 
    return view('evaluation.index');
})->name('evaluation');
