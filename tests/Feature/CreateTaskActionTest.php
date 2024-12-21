<?php

use App\Actions\Task\CreateTaskAction;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

test('create task', function () {
    (new DatabaseSeeder())->run();
    
    $user = User::query()->first();
    $tags = Tag::query()
        ->inRandomOrder()
        ->limit(2)
        ->pluck('id');

    $data = [
        'title' => 'New Task',
        'description' => 'Task description',
        'user_id' => $user->id,
        'tags' => $tags,
    ];

    $action = new CreateTaskAction();
    $task = $action->create($data);

    $this->assertInstanceOf(Task::class, $task);
    $this->assertCount(2, $task->tags);
});
