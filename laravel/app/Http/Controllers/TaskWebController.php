<?php


namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskWebController extends Controller
{

    public function index()
    {
        $tasks = Task::latest()->paginate(10);

        return view('tasks.index', compact('tasks'));
    }


    public function create()
    {
        return view('tasks.create');
    }

    /**
     * @param \App\Http\Requests\TaskRequest $request
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Задача успешно создана');
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param \App\Models\Task $task
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param \App\Http\Requests\TaskRequest $request
     * @param \App\Models\Task $task
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Задача успешно обновлена');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param \App\Models\Task $task
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Задача успешно удалена');
    }
}
