<?php

namespace App\Actions\Comment;

use App\Models\Comment;

class DeleteCommentAction
{
    public function delete(int $id)
    {
        return Comment::findOrFail($id)->delete();
    }
}