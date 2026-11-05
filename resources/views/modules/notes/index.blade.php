@extends('layouts.sandbox')

@section('title', 'Notepad Experiment Module')

@section('content')
<div class="space-y-6">
    <!-- Header banner details -->
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📝 Markdown Notepad Module</h1>
            <p class="text-sm text-gray-500 mt-0.5">Isolated learning project focusing on database ownership tracking and rich-text structures.</p>
        </div>
        <span class="bg-indigo-600 text-white font-semibold text-xs px-3 py-1 rounded-full shadow-sm">
            Total Saved: {{ $notes->count() }}
        </span>
    </div>

    <!-- Main Module Interface Layout split -->
    <div class="grid lg:grid-cols-3 gap-6 items-start">
        
        <!-- Left Side: Form input interface tool -->
        <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl shadow-sm">
            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide mb-4">Create New Sandbox Note</h2>
            
            <form action="{{ route('notes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-xs font-semibold text-gray-700 mb-1">Note Heading Title</label>
                    <input type="text" id="title" name="title" required placeholder="e.g., Learning Eloquent Scopes"
                        class="w-full text-sm rounded-md border border-gray-300 p-2 bg-white text-gray-700 shadow-sm focus:ring-1 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label for="category" class="block text-xs font-semibold text-gray-700 mb-1">Module Category Tag</label>
                    <select id="category" name="category" class="w-full text-xs rounded-md border border-gray-300 p-2 bg-white text-gray-700 shadow-sm">
                        <option value="General">General Notes</option>
                        <option value="Code">Code Snippets</option>
                        <option value="Study">Study References</option>
                        <option value="Todo">Task Lists</option>
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-xs font-semibold text-gray-700 mb-1">Note Content Playground</label>
                    <textarea id="content" name="content" rows="6" required placeholder="Type notes here... Supports basic paragraph typing."
                        class="w-full text-sm rounded-md border border-gray-300 p-2 bg-white text-gray-700 shadow-sm focus:ring-1 focus:ring-indigo-500 outline-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-2 rounded-md shadow-sm transition-all">
                    Save Note To Database
                </button>
            </form>
        </div>

        <!-- Right Side: Live listing grid container -->
        <div class="lg:col-span-2 space-y-4">
            @if($notes->isEmpty())
                <div class="p-8 border-2 border-dashed border-gray-200 rounded-xl text-center text-gray-400 bg-gray-50/50">
                    <span class="text-3xl block mb-1">🖊️</span>
                    <p class="font-medium text-sm">No experimental notes recorded yet.</p>
                    <p class="text-xs text-gray-400 mt-0.5">Use the input panel on the left to test out table mappings!</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($notes as $note)
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow relative flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $note->title }}</h3>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider 
                                        {{ $note->category === 'Code' ? 'bg-purple-50 text-purple-700 border border-purple-200' : '' }}
                                        {{ $note->category === 'Study' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                        {{ $note->category === 'General' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $note->category === 'Todo' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}">
                                        {{ $note->category }}
                                    </span>
                                </div>
                                
                                <!-- Rich Markdown Render Engine Block -->
                                <div class="prose prose-sm max-w-none text-gray-700 text-xs leading-relaxed space-y-2">
                                    {!! \App\Helpers\MarkdownHelper::parse($note->content) !!}
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-3 mt-4 flex justify-between items-center text-[11px] text-gray-400">
                                <span>Saved: {{ $note->created_at->diffForHumans() }}</span>
                                
                                <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Purge this experimental note record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>


    </div>
</div>
@endsection
