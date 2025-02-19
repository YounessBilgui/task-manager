<div class="p-6 bg-gray-900 min-h-screen text-gray-100">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-400">Task Manager</h1>
            <div class="flex items-center space-x-4">
                <input type="date" wire:model.lazy="selectedDate"
                    class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <select wire:model.lazy="selectedUser" class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2">
                <option value="">All Users</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <select wire:model.lazy="selectedStatus" class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2">
                <option value="">All Statuses</option>
                <option value="1">Done</option>
                <option value="0">Undone</option>
            </select>
        </div>

        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Task</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Created By</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Created At</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">{{ $task->title }}</td>
                            <td class="px-6 py-4">{{ $task->user->name }}</td>
                            <td class="px-6 py-4">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox"
                                        wire:change="updateStatus({{ $task->id }}, $event.target.checked)"
                                        class="w-5 h-5 rounded border-2 ml-5
                      {{ $task->status ? 'border-green-500 bg-green-500/20' : 'border-gray-500' }}
                      focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900"
                                        {{ $task->status ? 'checked' : '' }}>
                                    <span class="text-sm {{ $task->status ? 'text-green-500' : 'text-gray-400' }} ml-5">
                                        {{ $task->status ? 'Done' : 'Undone' }}
                                    </span>
                                </label>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $task->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($confirmingDeleteTask === $task->id)
                                    <div class="flex space-x-2">
                                        <button wire:click="deleteTask({{ $task->id }})" class="text-red-400 hover:text-red-300 transition-colors">
                                            Confirm Delete
                                        </button>
                                        <button wire:click="cancelDeleteTask" class="text-gray-400 hover:text-gray-300 transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                @else
                                    <button wire:click="confirmDeleteTask({{ $task->id }})" class="text-red-400 hover:text-red-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                No tasks found matching your criteria
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
