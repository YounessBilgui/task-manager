<div class="p-6 bg-gray-900 min-h-screen text-gray-100">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-indigo-400 mb-8">User Manager</h1>
        <form wire:submit.prevent="createUser" class="mb-8 bg-gray-800 rounded-xl p-6 shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-300">Name</label>
                    <input type="text" wire:model="name"
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400 text-gray-100 transition-all">
                    @error('name')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-300">Email</label>
                    <input type="email" wire:model="email"
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400 text-gray-100 transition-all">
                    @error('email')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-300">Password</label>
                    <input type="password" wire:model="password"
                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400 text-gray-100 transition-all">
                    @error('password')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                Create User
            </button>
        </form>
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="confirmDelete({{ $user->id }})"
                                    class="text-red-400 hover:text-red-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
    @if ($confirmingDelete)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
            <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-100 mb-4">Delete User?</h3>
                <p class="text-gray-400 mb-6">Are you sure you want to delete this user? This action cannot be undone.
                </p>
                <div class="flex justify-end gap-3">
                    <button wire:click="cancelDelete"
                        class="px-4 py-2 text-gray-300 hover:text-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="deleteUser({{ $confirmingDelete }})"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
