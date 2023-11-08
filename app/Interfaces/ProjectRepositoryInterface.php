<?php

namespace App\Interfaces;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface{

    public function getAllProjects(): Collection;
    public function getProjectById(int $projectId): Project;
    public function createProject(array $projectDetails) : Project;
    public function updateProject(Project $project, array $newDetails) : Project;
    public function deleteProject(Project $project);

    // public function getCompletedProjects();
}