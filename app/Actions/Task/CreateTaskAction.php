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
                $task->tags()->attach($data['tags']);
            }

            return $task;
        });
    }
}