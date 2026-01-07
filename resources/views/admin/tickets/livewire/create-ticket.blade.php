<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold mb-4">
                    Create Ticket
                </h3>

                <form wire:submit.prevent="save" class="space-y-4">

                    {{-- Template (optional) --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Template (optional)</label>
                        <select
                            wire:model="ticket_template_id"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        >
                            <option value="">-- none --</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">
                                    #{{ $template->id }}{{ isset($template->name) ? ' - '.$template->name : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('ticket_template_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Title --}}
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

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Description</label>
                        <textarea
                            wire:model.defer="description"
                            rows="4"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                        ></textarea>
                        @error('description') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Department / Area --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Department</label>
                            <input
                                type="text"
                                wire:model.defer="department"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                            >
                            @error('department') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Area</label>
                            <input
                                type="text"
                                wire:model.defer="area"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                            >
                            @error('area') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('admin.tickets.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white">
                            Save Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
