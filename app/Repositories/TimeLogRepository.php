<?php

namespace App\Repositories;

use App\Interfaces\TimeLogRepositoryInterface;
use App\Models\Timelog;

class TimeLogRepository implements TimeLogRepositoryInterface 
{
    public function getAllLogs() 
    {
        return Timelog::all();
    }

    public function getLogById($logId) 
    {
        return Timelog::findOrFail($logId);
    }

    public function deleteLog($logId) 
    {
        Timelog::destroy($logId);
    }

    public function createLog(array $logDetails) 
    {
        return Timelog::create($logDetails);
    }

    public function updateLog($logId, array $newDetails) 
    {
        return Timelog::whereId($logId)->update($newDetails);
    }

    public function getLogsByProjectId($projectId) 
    {
        ##TODO
        return Timelog::where('is_fulfilled', true);
    }

    public function getEvaluationStats(){
        ##Will write a query here and then call that query/raw inside evaluationDatatable
    }
}
