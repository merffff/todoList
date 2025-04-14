<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return new TaskCollection($tasks);
    }

    public function store(TaskRequest $request)
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

    public function show(Task $task)
    {
        return (new TaskResource($task))
            ->additional(['status' => 'success']);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return (new TaskResource($task))
            ->additional([
                'status' => 'success',
                'message' => 'Task updated successfully'
            ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ]);
    }
}
