<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-2xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold mb-4">
                    {{ $templateId ? 'Edit Ticket Template' : 'Create Ticket Template' }}
                </h3>

                <form wire:submit.prevent="save" class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">Title</label>
                        <input
                            type="text"
                            wire:model.defer="title"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                        @error('title') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Description</label>
                        <textarea
                            wire:model.defer="description"
                            rows="6"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        ></textarea>
                        @error('description') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Area</label>
                            <select
                                wire:model.defer="area_id"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                            >
                                <option value="">-- None --</option>
                                @foreach($areas as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                            @error('area_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Department</label>
                            <select
                                wire:model.defer="department_id"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                            >
                                <option value="">-- None --</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a
                            href="{{ route('controller.tickettemplates.index') }}"
                            class="inline-flex items-center px-4 py-2 rounded-md border"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white"
                        >
                            {{ $templateId ? 'Update Template' : 'Save Template' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
