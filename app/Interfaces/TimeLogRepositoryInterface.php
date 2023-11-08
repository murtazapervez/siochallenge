<?php

namespace App\Interfaces;

interface TimeLogRepositoryInterface{

    public function getAllLogs();
    public function getLogById($logId);
    public function deleteLog($logId);
    public function createLog(array $logDetails);
    public function updateLog($logId, array $newDetails);
    public function getLogsByProjectId($projectId);
}