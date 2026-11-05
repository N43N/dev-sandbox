<?php

namespace App\Http\Controllers\KanbanModule;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KanbanController extends Controller
{
    public function index()
    {
        // 🔒 Pull lane records cleanly straight from MySQL columns matching the active user
        $todo   = Task::where('user_id', Auth::id())->where('status', 'todo')->orderBy('position', 'asc')->get();
        $doing  = Task::where('user_id', Auth::id())->where('status', 'doing')->orderBy('position', 'asc')->get();
        $done   = Task::where('user_id', Auth::id())->where('status', 'done')->orderBy('position', 'asc')->get();

        return view('modules.kanban.index', compact('todo', 'doing', 'done'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'todo',
        ]);

        return redirect()->route('kanban.index');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Security Gate: Prevent updating other users' items
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->route('kanban.index');
    }

    public function destroy(Task $task)
    {
        // Security Gate: Prevent deleting other users' items
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('kanban.index');
    }
}
