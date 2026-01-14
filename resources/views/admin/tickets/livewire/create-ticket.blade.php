<div class="min-h-[calc(100dvh-8rem)] flex justify-center items-start bg-gray-100 dark:bg-gray-900 py-4 sm:py-8">
    <div class="w-full max-w-xl px-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">

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

                        <div class="relative">
                            <label class="block text-sm font-medium mb-1" title="Start typing area name (min 2 letters)">Area</label>

                            <input
                                type="text"
                                wire:model.live="area_search"
                                wire:focus="$set('show_area_dropdown', true)"
                                wire:keydown.escape="closeAreaDropdown"
                                class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-900 focus:ring focus:ring-blue-500/40"
                                placeholder="Start typing area name (min 2 chars)..."
                                title="Start typing area name (min 2 letters)"
                                autocomplete="off"
                            />

                            {{-- store the actual selected value for validation/save --}}
                            <input type="hidden" wire:model="area">

                            @error('area') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror

                            @if($show_area_dropdown)
                                <div
                                    class="absolute z-20 mt-1 w-full rounded-md border border-gray-200 dark:border-gray-700
                                        bg-white dark:bg-gray-900 shadow-lg
                                        max-h-48 sm:max-h-60 overflow-y-auto overscroll-contain"
                                >
                                    @if(mb_strlen(trim($area_search)) < 2)
                                        <div class="px-3 py-2 text-sm text-gray-500">
                                            Type at least 2 characters…
                                        </div>
                                    @elseif($areas->isEmpty())
                                        <div class="px-3 py-2 text-sm text-gray-500">
                                            No matches.
                                        </div>
                                    @else
                                        @foreach($areas as $areaRow)
                                            <button
                                                type="button"
                                                wire:click="selectArea(@js($areaRow->name))"
                                                class="w-full text-left px-4 py-3 text-sm
                                                    hover:bg-gray-100 dark:hover:bg-gray-800
                                                    active:bg-gray-200 dark:active:bg-gray-700"
                                            >
                                                {{ $areaRow->name }}
                                            </button>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 pt-4">
                        <a href="{{route('admin.tickets.index')}}"
                           class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 rounded-md
                                border border-gray-300 dark:border-gray-700">
                            Cancel
                        </a>

                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 rounded-md
                                bg-blue-600 text-white">
                            Save Ticket
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
