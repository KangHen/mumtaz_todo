<?php

namespace App\Actions\Comment;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class CreateCommentAction
{
    public function create(array $data): Comment
    {
        $task = Task::find($data['task_id']);

        return DB::transaction(function () use ($data, $task) {
            $comment = new Comment();
            $comment->content = $data['content'];
            $comment->user_id = $data['user_id'];
            $comment->commentable()->associate($task);
            $comment->save();    

            return $comment;
        });
    }
}