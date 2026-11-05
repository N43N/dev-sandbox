<?php

namespace App\Http\Controllers\NoteModule;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        // Pull only notes belonging exclusively to the active user
        $notes = Note::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
        return view('modules.notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'content'  => ['required', 'string'],
            'category' => ['required', 'string', 'in:General,Code,Study,Todo'],
        ]);

        Note::create([
            'user_id'  => Auth::id(),
            'title'    => $request->title,
            'content'  => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->route('notes.index')->with('success', 'Experimental note saved!');
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
