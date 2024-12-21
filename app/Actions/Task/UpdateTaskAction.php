<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class UpdateTaskAction
{
    public function update(array $data, int $id): Task
    {
        return DB::transaction(function () use ($data, $id) {
            $task = Task::findOrFail($id);

            $task->update([
                'title' => $data['title'],
                'description' => $data['description'],
            ]);
    
            $task->tags()->sync($data['tags'] ?? []);
            
            return $task;
        });
    }
}