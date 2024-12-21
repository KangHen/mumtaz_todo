<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class CreateTaskAction
{
    public function create(array $data): Task
    {
        return DB::transaction(function () use ($data) {
            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'user_id' => $data['user_id'],
            ]);

            if (isset($data['tags'])) {
                $tagIds = Tag::whereIn('id', $data['tags'])->pluck('id');
                $task->tags()->sync($tagIds);
            }

            return $task;
        });
    }
}