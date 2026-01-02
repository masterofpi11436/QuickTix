<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold mb-4">
                    {{ $userId ? 'Edit User' : 'Create User' }}
                </h3>

                <form wire:submit.prevent="submitForm" class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">First Name</label>
                        <input
                            type="text"
                            wire:model="first_name"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('first_name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Middle Initial</label>
                        <input
                            type="text"
                            wire:model="middle_initial"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('middle_initial') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                   <div>
                        <label class="block text-sm font-medium mb-1">Last Name</label>
                        <input
                            type="text"
                            wire:model="last_name"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('last_name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input
                            type="email"
                            wire:model="email"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Role</label>
                        <select
                            wire:model="role"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                            <option value="User">User</option>
                            <option value="Reporting User">Reporting User</option>
                            <option value="Technician">Technician</option>
                            <option value="Controller">Controller</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                        @error('role') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Department</label>
                        <select wire:model="department_id" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40">
                            <option value="">-- None --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md border">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white">
                            {{ $userId ? 'Update User' : 'Save User' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
