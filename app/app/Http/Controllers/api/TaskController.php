<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
//       $tasks = $project->tasks()->with('assignedUser')->paginate(10);

        $tasks = Cache::remember('task_list', 60, function () use ($project) {
            return $project->tasks()->with('assignedUser')->paginate(10);
        });
       return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request,Project $project)
    {
        try {
            $this->taskService->store($request->all(),$project);
            return response()->json([
                'status' => true,
                'message' => 'تسک مربوط به پروژه ' . $project->title .' با موفقیت ایجاد شد',
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
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
            $this->taskService->update($request->all(),$task);
        try {

            return response()->json([
                'status' => true,
                'message' => 'ویرایش شد',
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
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            Cache::forget('task_list');
            return response()->json([
                'status' => true,
                'message' => 'تسک حذف شد',
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
}
