<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => TaskResource::collection($tasks),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total()
            ]
        ]);
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return (new TaskResource($task))
            ->additional([
                'status' => 'success',
                'message' => 'Task created successfully'
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Task $task): JsonResponse
    {
        return (new TaskResource($task))
            ->additional(['status' => 'success'])
            ->response();
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return (new TaskResource($task))
            ->additional([
                'status' => 'success',
                'message' => 'Task updated successfully'
            ])
            ->response();
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ]);
    }
}
