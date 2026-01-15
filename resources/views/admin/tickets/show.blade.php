<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate">
                    Ticket Details
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    View details and assign this ticket.
                </p>
            </div>

            <div class="shrink-0">
                <x-custom-button href="{{ route('admin.tickets.index') }}" color="green">
                    Back
                </x-custom-button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 rounded-2xl p-6 sm:p-8 space-y-8">

                {{-- Flash Messages --}}
                <x-flash-message type="success" />

                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 dark:border-red-900/50 bg-red-50 dark:bg-red-900/20 px-4 py-3 text-red-800 dark:text-red-200">
                        <p class="font-semibold">Please fix the errors below.</p>
                    </div>
                @endif

                {{-- Ticket Meta Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Ticket ID</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">#{{ $ticket->id }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $ticket->status }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Area</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $ticket->area }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Department</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $ticket->department }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Left: Details --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Submitted By --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-5">
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Submitted By</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                                {{ $ticket->submittedBy?->first_name }} {{ $ticket->submittedBy?->last_name }}
                                <span class="ml-2 font-normal text-sm text-gray-500 dark:text-gray-400">
                                    ({{ $ticket->submittedBy?->email }})
                                </span>
                            </p>
                        </div>

                        {{-- Title --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Title</p>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $ticket->title }}
                            </p>
                        </div>

                        {{-- Description --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Description</p>
                            </div>

                            <div class="mt-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4 text-gray-800 dark:text-gray-200 whitespace-pre-wrap">
                                {{ $ticket->description }}
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Notes</p>
                            </div>

                            <div class="mt-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4 text-gray-800 dark:text-gray-200 whitespace-pre-wrap">
                                {{ $ticket->notes }}
                            </div>
                        </div>

                        {{-- Timestamps Footer --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Created:</span>
                                    {{ $ticket->created_at->format('M d, Y H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Last Updated:</span>
                                    {{ $ticket->updated_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Assign Panel --}}
                    <div class="space-y-6">
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Assign Ticket
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Choose an eligible user (Technician / Controller / Admin).
                            </p>

                            <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}" class="mt-4 space-y-3">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Assign to
                                    </label>

                                    <select
                                        id="assigned_to"
                                        name="assigned_to"
                                        class="mt-2 w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5 text-gray-900 dark:text-gray-100
                                               shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    >
                                        <option value="">-- Select user --</option>
                                            @php
                                                $grouped = $assignees->groupBy(fn ($u) => $u->role->value);
                                            @endphp

                                            @foreach (['Technician', 'Controller', 'Administrator'] as $group)
                                                @if ($grouped->has($group))
                                                    <option disabled class="font-semibold text-gray-500">
                                                        — {{ $group }}s —
                                                    </option>

                                                    @foreach ($grouped[$group] as $user)
                                                        @php
                                                            $userName = $user->first_name . ' ' . $user->last_name;
                                                        @endphp

                                                        <option
                                                            value="{{ $user->id }}"
                                                            @selected(old('assigned_to', $ticket->technician) === $userName)
                                                        >
                                                            {{ $userName }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                    </select>

                                    @error('assigned_to')
                                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}">
                                        @csrf
                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="w-full inline-flex items-center justify-center rounded-lg
                                                bg-transparent dark:bg-transparent
                                                border border-green-600 dark:border-green-400
                                                px-4 py-2 text-sm font-semibold
                                                text-green-700 dark:text-green-400
                                                shadow-sm
                                                hover:bg-green-50 dark:hover:bg-green-900
                                                focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2
                                                dark:focus:ring-offset-gray-800"
                                        >
                                            Assign
                                        </button>
                                    </form>
                                </div>
                            </form>
                        </div>

                        {{-- Quick Actions (optional) --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Actions</p>
                            <div class="mt-3 flex flex-col gap-2">
                                <x-custom-button
                                    href="{{ route('admin.tickets.destroy', $ticket) }}"
                                    method="DELETE"
                                    color="red"
                                    class="w-full justify-center"
                                >
                                    Delete Ticket
                                </x-custom-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
