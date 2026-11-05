<div class="bg-white border border-gray-200 rounded-lg p-3 shadow-sm hover:shadow transition-shadow">
    <div class="flex justify-between items-start gap-2">
        <h4 class="font-bold text-gray-800 text-xs leading-snug">{{ $task->title }}</h4>
        
        <form action="{{ route('kanban.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Archive this ticket?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors text-[10px]">✕</button>
        </form>
    </div>
    
    @if($task->description)
        <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">{{ $task->description }}</p>
    @endif

    <div class="mt-3 pt-2 border-t border-gray-50 flex justify-between items-center">
        <span class="text-[9px] text-gray-400 font-medium">{{ $task->updated_at->diffForHumans() }}</span>

        @if($nextStatus)
            <form action="{{ route('kanban.updateStatus', $task->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $nextStatus }}">
                <button type="submit" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 tracking-wide">
                    {{ $nextLabel }}
                </button>
            </form>
        @else
            <span class="text-[10px] font-bold text-emerald-600 tracking-wide">✓ Done</span>
        @endif
    </div>
</div>
