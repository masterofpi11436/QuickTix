<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold mb-4">
                    {{ $statusId ? 'Edit Status' : 'Create Status' }}
                </h3>

                <form wire:submit.prevent="submitForm" class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">Name</label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Status Type</label>
                        <select
                            wire:model="status_type"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                            <option value="">-- Select a Status Type --</option>
                            <option value="in_progress">In progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        @error('status_type') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('controller.statuses.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md border">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white">
                            {{ $statusId ? 'Update Status' : 'Save Status' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
