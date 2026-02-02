<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold mb-4">
                    {{ $allowedDomainId ? 'Edit Allowed Domain' : 'Create Allowed Domain' }}
                </h3>

                <form wire:submit.prevent="submitForm" class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">Domain</label>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="example.com"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            id="is_active"
                            wire:model="is_active"
                            class="rounded border-gray-300 dark:border-gray-700 text-blue-600"
                        >
                        <label for="is_active" class="text-sm font-medium">Active</label>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('admin.allowed-domains.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md border">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white">
                            {{ $allowedDomainId ? 'Update Domain' : 'Save Domain' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
