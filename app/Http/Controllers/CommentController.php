<?php

namespace App\Http\Controllers;

use App\Actions\Comment\CreateCommentAction;
use App\Actions\Comment\DeleteCommentAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private int $userId;
    public function __construct(){
        $this->userId = Auth::id();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateCommentAction $createCommentAction)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'task_id' => 'required|exists:tasks,id',
        ]);

        $validated['user_id'] = $this->userId;

        $createCommentAction->create($validated);

        return redirect()->route('dashboard')->with('success', 'Comment created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCommentAction $deleteCommentAction, int $id)
    {
        $deleteCommentAction->delete($id);

        return redirect()->route('dashboard')->with('success', 'Comment deleted successfully!');
    }
}
