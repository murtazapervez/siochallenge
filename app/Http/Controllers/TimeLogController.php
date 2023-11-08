<?php

namespace App\Http\Controllers;

use App\DataTables\TimelogDataTable;
use App\Http\Requests\CreateTimelogValidation;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TimeLogRepositoryInterface;
use App\Models\Timelog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    private $timeLogRepository;
    private $taskRepository;

    public function __construct(TimeLogRepositoryInterface $timeLogRepository, TaskRepositoryInterface $taskRepository) {
        $this->timeLogRepository = $timeLogRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TimelogDataTable $timelogDataTable)
    {
        
        return $timelogDataTable->render('timelog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = $this->taskRepository->getAllTasks();

        return view('timelog.form', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTimelogValidation $request)
    {
        $request->merge([
            'user_id' => Auth::id()
        ]);

        $log = $this->timeLogRepository->createLog($request->all());

        return redirect()->route('timelog.index')->with('success', 'TimeLog created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tasks = $this->taskRepository->getAllTasks();
        $timeLog = $this->timeLogRepository->getLogById($id);

        return view('timelog.form', compact('timeLog','tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timelog $timelog)
    {
        $this->timeLogRepository->updateLog($timelog, $request->except(['_token', '_method', '']));

        return redirect()->route('timelog.index')->with('success', 'TimeLog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->timeLogRepository->deleteLog($id);
        
        return redirect()->route('timelog.index')->with('success', 'TimeLog deleted successfully!');

    }
}
