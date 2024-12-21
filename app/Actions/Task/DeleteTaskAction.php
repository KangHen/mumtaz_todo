<?php

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DeleteTaskAction
{
    public function delete(int $id)
    {
        return Task::findOrFail($id)->delete();
    }
}