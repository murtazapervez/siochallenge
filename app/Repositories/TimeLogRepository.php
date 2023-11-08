<?php

namespace App\Repositories;

use App\Interfaces\TimeLogRepositoryInterface;
use App\Models\Timelog;
use Illuminate\Support\Facades\DB;

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

    public function getEvaluationStats()
    {
        $timeSpentByUsers = Timelog::with('user')
            ->selectRaw('user_id, SUM((SUBSTRING(end_time, 1, 2) * 60 + SUBSTRING(end_time, 4, 2)) - (SUBSTRING(start_time, 1, 2) * 60 + SUBSTRING(start_time, 4, 2))) / 60 AS total_time_spent_in_hours')
            ->groupBy('user_id');

        return $timeSpentByUsers;
    }
}
