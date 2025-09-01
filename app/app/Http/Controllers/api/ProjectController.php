<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{

    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $projects = Project::with('tasks')->paginate(10);
        $projects = Cache::remember('projects_list', 60, function () {
            return Project::with('tasks')->paginate(10);
        });

        return ProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $this->projectService->store($request->all());

            return response()->json([
                'status' => true,
                'message' => 'پروژه جدید با موفقیت ایجاد شد',
            ],201);
        }
        catch (\Exception $exception)
        {
            return response()->json([
                'status' => false,
                'message' => 'خطایی رخ داده است مجددا تلاش کنید',
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
