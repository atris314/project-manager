<?php

namespace App\Services;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

/**
 * Class ProjectService.
 */
class ProjectService
{
    public function store(array $params)
    {

        $project = new Project();
        $project->title = $params['title'];
        $project->description = $params['description'];
        $project->start_date = $params['start_date'];
        $project->end_date = $params['end_date'];
        $project->status = $params['status'] ?? ProjectStatus::PENDING;
        $project->owner_id = auth()->id();
        $project->save();

        Cache::forget('projects_list');

        return $project;
    }
}
