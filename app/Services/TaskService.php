<?php
namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function getAllTasksForUser(int $userId): Collection
    {
        return Task::query()
            ->where('user_id', $userId)
            ->with(['tags', 'comments'])
            ->get();
    }

    public function getTaskById(int $id): Task
    {
        return Task::query()
            ->where('id', $id)
            ->with(['tags', 'comments'])
            ->firstOrFail();
    }
}
