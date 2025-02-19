<div class="p-6 bg-gray-900 min-h-screen text-gray-100">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-indigo-400">Task Dashboard</h1>

        <form wire:submit.prevent="{{ $editMode ? 'updateTask' : 'createTask' }}"
            class="mb-8 bg-gray-800 rounded-xl p-6 shadow-lg">
            <div class="mb-5">
                <label for="title" class="block text-sm font-medium mb-2 text-gray-300">Task Title</label>
                <input type="text" id="title" wire:model="title"
                    class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400 text-gray-100 transition-all">
                @error('title')
                    <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            @if ($editMode)
                <div class="flex gap-3">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                        Update Task
                    </button>
                    <button type="button" wire:click="cancelEdit"
                        class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
            @else
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                    Add Task
                </button>
            @endif
        </form>

        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-800/30 border border-green-500 text-green-300 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 shrink-0" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <div class="space-y-4">
            <h2 class="text-xl font-semibold mb-4 text-gray-300">Your Tasks</h2>

            @if ($tasks->isEmpty())
                <div class="text-gray-400 text-center py-8 bg-gray-800 rounded-lg">
                    No tasks found. Start by creating one!
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($tasks as $task)
                        <div
                            class="flex items-start space-x-3 group bg-gray-800 hover:bg-gray-700/60 p-4 rounded-lg transition-all border border-gray-700">
                            <input type="checkbox" wire:click="toggleTask({{ $task->id }})"
                                class="mt-1.5 w-5 h-5 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500 cursor-pointer"
                                @checked($task->status)>

                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3
                                        class="text-base font-medium {{ $task->status ? 'text-gray-500 line-through' : 'text-gray-200' }}">
                                        {{ $task->title }}
                                    </h3>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="editTask({{ $task->id }})"
                                            class="text-indigo-400 hover:text-indigo-300 transition-colors p-1.5 rounded-lg hover:bg-gray-600/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $task->id }})"
                                            class="text-red-400 hover:text-red-300 transition-colors p-1.5 rounded-lg hover:bg-gray-600/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @if ($task->description)
                                    <p
                                        class="mt-1 text-sm {{ $task->status ? 'text-gray-500 line-through' : 'text-gray-400' }}">
                                        {{ $task->description }}
                                    </p>
                                @endif
                                <div class="mt-2 text-xs {{ $task->status ? 'text-gray-600' : 'text-gray-500' }}">
                                    Created {{ $task->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($confirmingDelete)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
                <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                    <h3 class="text-lg font-medium text-gray-100 mb-4">Delete Task?</h3>
                    <p class="text-gray-400 mb-6">Are you sure you want to delete this task? This action cannot be
                        undone.</p>
                    <div class="flex justify-end gap-3">
                        <button wire:click="cancelDelete"
                            class="px-4 py-2 text-gray-300 hover:text-gray-100 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="deleteTask({{ $confirmingDelete }})"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            Delete Task
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
