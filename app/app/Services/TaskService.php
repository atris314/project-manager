<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Facades\Cache;

/**
 * Class TaskService.
 */
class TaskService
{
    public function store(array $params,$project)
    {
        $task = new Task();
        $task->title = $params['title'];
        $task->description = $params['description'];
        $task->status = $params['status'] ?? TaskStatus::TODO;
        $task->assigned_to = auth()->id();
        $task->project_id = $project->id;
        $task->save();

        Cache::forget('task_list');

        return $task;
    }

    public function update(array $params,$task)
    {

        if (isset($params['status'])) {
            $params['status'] = TaskStatus::from($params['status']);
        }
        $task->update($params);
        Cache::forget('task_list');
    }
}
