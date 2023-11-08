<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectsDataTable;
use App\DataTables\TaskDataTable;
use App\DataTables\UserTimeSpentTableDataTable;
use App\Http\Requests\CreateProjectValidation;
use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private $projectRepository;
    
    public function __construct(ProjectRepositoryInterface $projectRepository) {
        $this->projectRepository = $projectRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectsDataTable $projectsDataTable)
    {        
        return $projectsDataTable->render('project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectValidation $request)
    {
        
        $request->merge([
            'created_by' => Auth::id()
        ]);

        $projects = $this->projectRepository->createProject($request->all());

        return redirect()->route('project.index')->with('success', 'Project created successfully!');

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
    public function edit(Project $project, TaskDataTable $taskDataTable, UserTimeSpentTableDataTable $userTimeSpentTableDataTable)
    {
        // $stats_table = $userTimeSpentTableDataTable->render('project.form');

        return $taskDataTable->with('id', $project->id)->render('project.form', compact('project'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->projectRepository->updateProject($project, $request->all());

        return redirect()->route('project.index')->with('success', 'Project updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAllProjects() 
    {
        $projects = $this->projectRepository->getAllProjects();
        return response()->json([
            "msg" => "success",
            "data" => $projects,
            "success" => true
        ]);
    }
}
