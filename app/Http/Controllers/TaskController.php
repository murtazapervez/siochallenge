<?php

namespace App\Http\Controllers;

use App\DataTables\TaskDataTable;
use App\DataTables\TimelogDataTable;
use App\Http\Requests\CreateTaskValidation;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    private $taskRepository;
    private $projectRepository;

    public function __construct(TaskRepositoryInterface $taskRepository, ProjectRepositoryInterface $projectRepository) {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskDataTable $taskDataTable)
    {
        return $taskDataTable->render('task.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = $this->projectRepository->getAllProjects();
        
        return view('task.form', compact('projects') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskValidation $request)
    {
        $request->merge([
            'created_by' => Auth::id()
        ]);

        $task = $this->taskRepository->createTask($request->all());

        return redirect()->route('task.index')->with('success', 'Task created successfully!');

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
    public function edit(Task $task, TimelogDataTable $timelogDataTable)
    {
        $projects = $this->projectRepository->getAllProjects();

        return $timelogDataTable->with('id', $task->id)->render('task.form', compact('task','projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {        
        $this->taskRepository->updateTask($task, $request->except(['_token', '_method', '']));

        return redirect()->route('task.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->taskRepository->deleteTask ($id);
        
        // return redirect()->route('timelog.index')->with('success', 'TimeLog deleted successfully!');

    }
}
