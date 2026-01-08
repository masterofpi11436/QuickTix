<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold mb-4">
                    Create Ticket
                </h3>

                @if (session('success'))
                    <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

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
                            <select
                                wire:model="department"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                            >
                                <option value="">-- select department --</option>
                                @foreach($departments as $departmentRow)
                                    <option value="{{ $departmentRow->name }}">{{ $departmentRow->name }}</option>
                                @endforeach
                            </select>
                            @error('department') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Area</label>
                            <select
                                wire:model="area"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                       bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                            >
                                <option value="">-- select area --</option>
                                @foreach($areas as $areaRow)
                                    <option value="{{ $areaRow->name }}">{{ $areaRow->name }}</option>
                                @endforeach
                            </select>
                            @error('area') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="#"
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
