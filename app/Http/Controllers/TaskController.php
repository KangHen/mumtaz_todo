<?php

namespace App\Http\Controllers;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\DeleteTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Services\TagService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    private int $userId;
    public function __construct(
        private TaskService $taskService,
        public TagService $tagService
    ){
        $this->userId = Auth::id();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskService->getAllTasksForUser($this->userId);
        return Inertia::render('Task/Index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = $this->tagService->getAllTags();
        return Inertia::render('Task/Create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateTaskAction $createTaskAction)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id',
        ]);

        $validated['user_id'] = $this->userId;
        $createTaskAction->create($validated);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tags = $this->tagService->getAllTags();
        $task = $this->taskService->getTaskById($id);
        $taskTags = $task->tags->pluck('id')->toArray();

        return Inertia::render('Task/Edit', [
            'task' => $task,
            'tags' => $tags,
            'taskTags' => $taskTags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UpdateTaskAction $updateTaskAction, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $updateTaskAction->update($validated, $id);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteTaskAction $deleteTaskAction, int $id)
    {
        $deleteTaskAction->delete($id);

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }
}
