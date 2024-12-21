<?php

namespace App\Actions\Task;

use App\Models\Task;

class DeleteTaskAction
{
    public function delete(int $id)
    {
        return Task::findOrFail($id)->delete();
    }
}