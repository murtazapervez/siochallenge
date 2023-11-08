<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{

    public function getAllProjects(): Collection
    {
        return Project::all();
    }

    public function getProjectById(int $projectId): Project
    {
        return Project::find($projectId);
    }
    
    public function createProject(array $projectDetails) : Project
    {
        return Project::create($projectDetails);
    }

    public function updateProject(Project $project, array $newDetails) : Project
    {
        $project->update($newDetails);

        return $project;
    }
    
    public function deleteProject(Project $project)
    {
        return $project->delete();
    }
}
