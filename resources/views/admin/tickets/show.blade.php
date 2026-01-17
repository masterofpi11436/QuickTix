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
                <x-flash-message type="error" />

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
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $statusLabels[$ticket->status_type->value] ?? $ticket->status_type->label() }}
                        </p>
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
                            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Description</p>

                            <div class="mt-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4 text-gray-800 dark:text-gray-200 whitespace-pre-wrap">
                                {{ trim($ticket->description ?? '') }}
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
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Actions</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Assign the ticket, add/update notes, or mark it completed.
                            </p>

                            {{-- If completed: show read-only --}}
                            @if ($ticket->status_type === \App\Enums\StatusType::Completed)
                                <div class="mt-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">This ticket is complete.</p>
                                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                        {{ trim($ticket->notes ?? 'No notes provided.') }}
                                    </p>
                                </div>
                            @else
                                {{-- ONE form that handles assign + notes --}}
                                <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}" class="mt-4 space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Assign to
                                        </label>

                                        <select
                                            id="assigned_to"
                                            name="assigned_to"
                                            class="mt-2 w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5
                                                text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        >
                                            <option value="">-- Select user --</option>

                                            @php
                                                $grouped = $assignees->groupBy(function ($u) {
                                                    return $u->role instanceof \App\Enums\UserRole ? $u->role->value : (string) $u->role;
                                                });

                                                $roleOrder = [
                                                    \App\Enums\UserRole::Technician->value => 'Technician',
                                                    \App\Enums\UserRole::Controller->value => 'Controller',
                                                    \App\Enums\UserRole::Administrator->value => 'Administrator',
                                                ];
                                            @endphp

                                            @foreach ($roleOrder as $roleValue => $label)
                                                @if ($grouped->has($roleValue))
                                                    <option disabled class="font-semibold text-gray-500">— {{ $label }}s —</option>

                                                    @foreach ($grouped[$roleValue] as $user)
                                                        @php $userName = trim($user->first_name.' '.$user->last_name); @endphp

                                                        <option
                                                            value="{{ $user->id }}"
                                                            @selected(old('assigned_to', $ticket->assigned_to_user_id) == $user->id)
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
                                        <label for="technical_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Technical Notes (optional)
                                        </label>
                                        <textarea
                                            id="technical_notes"
                                            name="technical_notes"
                                            rows="5"
                                            class="mt-2 w-full rounded-xl border border-gray-300 dark:border-gray-600
                                                bg-white dark:bg-gray-800 px-3 py-2.5 text-gray-900 dark:text-gray-100"
                                        >{{ old('technical_notes', $ticket->technical_notes) }}</textarea>

                                        @error('notes')
                                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button
                                        type="submit"
                                        class="w-full inline-flex items-center justify-center rounded-lg
                                            bg-transparent dark:bg-transparent
                                            border border-blue-600 dark:border-blue-400
                                            px-4 py-2 text-sm font-semibold
                                            text-blue-700 dark:text-blue-400
                                            shadow-sm hover:bg-blue-50 dark:hover:bg-blue-900"
                                    >
                                        Save Assignment / Notes
                                    </button>
                                </form>

                                {{-- Separate form for completion (uses the same notes field name, but separate request) --}}
                                @if ($ticket->status_type === \App\Enums\StatusType::InProgress)
                                <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}" class="mt-6 space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="completed_status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Completed status
                                        </label>
                                        <select
                                            id="completed_status_id"
                                            name="completed_status_id"
                                            required
                                            class="mt-2 w-full rounded-xl border border-gray-300 dark:border-gray-600
                                                bg-white dark:bg-gray-800 px-3 py-2.5
                                                text-gray-900 dark:text-gray-100 shadow-sm
                                                focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        >
                                            <option value="">-- Select completed status --</option>
                                            @foreach ($completedStatuses as $s)
                                                <option value="{{ $s->id }}" @selected(old('completed_status_id') == $s->id)>
                                                    {{ $s->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('completed_status_id')
                                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="complete_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Notes (optional)
                                        </label>
                                        <textarea
                                            id="complete_notes"
                                            name="notes"
                                            rows="4"
                                            class="mt-2 w-full rounded-xl border border-gray-300 dark:border-gray-600
                                                bg-white dark:bg-gray-800 px-3 py-2.5 text-gray-900 dark:text-gray-100"
                                        >{{ old('notes', $ticket->notes) }}</textarea>

                                        @error('notes')
                                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button
                                        type="submit"
                                        class="w-full inline-flex items-center justify-center rounded-lg
                                            bg-transparent dark:bg-transparent
                                            border border-green-600 dark:border-green-400
                                            px-4 py-2 text-sm font-semibold
                                            text-green-700 dark:text-green-400
                                            shadow-sm hover:bg-green-50 dark:hover:bg-green-900"
                                    >
                                        Complete Ticket
                                    </button>
                                </form>
                                @endif
                            @endif

                            {{-- Optional: jargon editor) --}}
                            @php
                                $role = auth()->user()?->role instanceof \App\Enums\UserRole
                                    ? auth()->user()->role->value
                                    : (string) (auth()->user()?->role ?? '');

                                $canEditJargon = in_array($role, [
                                    \App\Enums\UserRole::Administrator->value,
                                    \App\Enums\UserRole::Controller->value,
                                    \App\Enums\UserRole::Technician->value,
                                ], true);

                                $isCompleted = $ticket->status_type === \App\Enums\StatusType::Completed;
                            @endphp

                            @if ($canEditJargon && ! $isCompleted)
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Status</p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Changes the default label shown for this status type.
                                    </p>

                                    <form method="POST" action="{{ route('admin.status-type-defaults.update', $ticket->status_type->value) }}" class="mt-3 space-y-3">
                                        @csrf
                                        @method('PUT')

                                        <select
                                            name="status_id"
                                            class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5
                                                text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                            @foreach(($statusesByType[$ticket->status_type->value] ?? collect()) as $s)
                                                <option value="{{ $s->id }}">
                                                    {{ $s->name }}{{-- Ticket Meta Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Ticket ID</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">#{{ $ticket->id }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</p>
                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $statusLabels[$ticket->status_type->value] ?? $ticket->status_type->label() }}
                        </p>
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
                                                </option>
                                            @endforeach
                                        </select>

                                        <button
                                            type="submit"
                                            class="w-full inline-flex items-center justify-center rounded-lg
                                                bg-transparent dark:bg-transparent
                                                border border-gray-300 dark:border-gray-600
                                                px-4 py-2 text-sm font-semibold
                                                text-gray-800 dark:text-gray-200
                                                hover:bg-gray-50 dark:hover:bg-gray-900"
                                        >
                                            Update Status
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- Delete Ticket stays separate --}}
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Danger zone</p>

                            <form
                                method="POST"
                                action="{{ route('admin.tickets.destroy', $ticket) }}"
                                class="mt-3"
                                onsubmit="return confirm('Are you sure you want to permanently delete this ticket? This action cannot be undone.')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center rounded-lg
                                        bg-transparent dark:bg-transparent
                                        border border-red-600 dark:border-red-400
                                        px-4 py-2 text-sm font-semibold
                                        text-red-700 dark:text-red-400
                                        shadow-sm hover:bg-red-50 dark:hover:bg-red-900"
                                >
                                    Delete Ticket
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
