@extends('layouts.sandbox')

@section('title', 'Kanban Board Experiment')

@section('content')
<div class="space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📋 Kanban Board Module</h1>
            <p class="text-sm text-gray-500 mt-0.5">Isolated task lifecycle module utilizing state patch arrays and form-switch toggles.</p>
        </div>
    </div>

    <!-- Task Creator Panel -->
    <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm max-w-xl">
        <h2 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">Add New Task Ticket</h2>
        <form action="{{ route('kanban.store') }}" method="POST" class="flex gap-3 items-end">
            @csrf
            <div class="flex-1">
                <input type="text" name="title" required placeholder="Task Title..."
                    class="w-full text-xs rounded-md border border-gray-300 p-2 bg-white text-gray-700 shadow-sm outline-none focus:ring-1 focus:ring-indigo-500">
            </div>
            <div class="flex-1">
                <input type="text" name="description" placeholder="Short description (optional)..."
                    class="w-full text-xs rounded-md border border-gray-300 p-2 bg-white text-gray-700 shadow-sm outline-none focus:ring-1 focus:ring-indigo-500">
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs px-4 py-2 rounded-md shadow-sm transition-all whitespace-nowrap">
                + Create
            </button>
        </form>
    </div>

    <!-- The 3 Kanban Board Columns Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        
        <!-- Lane 1: TODO -->
        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl min-h-[300px]">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-gray-700 text-sm flex items-center gap-1.5">📌 To Do</h3>
                <span class="bg-gray-200 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $todo->count() }}</span>
            </div>
            <div class="space-y-3">
                @foreach($todo as $task)
                    @include('modules.kanban.card', ['task' => $task, 'nextStatus' => 'doing', 'nextLabel' => 'Start Work →'])
                @endforeach
            </div>
        </div>

        <!-- Lane 2: DOING -->
        <div class="bg-blue-50/40 border border-blue-100 p-4 rounded-xl min-h-[300px]">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-blue-800 text-sm flex items-center gap-1.5">⚡ In Progress</h3>
                <span class="bg-blue-200 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $doing->count() }}</span>
            </div>
            <div class="space-y-3">
                @foreach($doing as $task)
                    @include('modules.kanban.card', ['task' => $task, 'nextStatus' => 'done', 'nextLabel' => 'Complete ✓'])
                @endforeach
            </div>
        </div>

        <!-- Lane 3: DONE -->
        <div class="bg-emerald-50/40 border border-emerald-100 p-4 rounded-xl min-h-[300px]">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-emerald-800 text-sm flex items-center gap-1.5">🎉 Completed</h3>
                <span class="bg-emerald-200 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $done->count() }}</span>
            </div>
            <div class="space-y-3">
                @foreach($done as $task)
                    @include('modules.kanban.card', ['task' => $task, 'nextStatus' => null])
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
