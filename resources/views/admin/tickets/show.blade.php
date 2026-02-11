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
                @if ($ticket->status_type === \App\Enums\StatusType::Completed)
                    <x-custom-button href="{{ route('admin.tickets.completed-tickets') }}" color="green">
                        Back to Completed Tickets
                    </x-custom-button>
                @else
                    <x-custom-button href="{{ route('admin.tickets.index') }}" color="green">
                        Back
                    </x-custom-button>
                @endif
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

                            <div class="mt-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4 text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ trim($ticket->description) }}</div>
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

                        {{-- Assign to / Technical Notes --}}
                        <div class="rounded-2xl border border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 p-5">
                            @if ($ticket->status_type === \App\Enums\StatusType::Completed)
                                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Technician Notes:</p>
                                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ trim($ticket->notes ?? 'No notes submitted by technician.') }}</p>
                                </div>
                                <div class="mt-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Completed By:</p>
                                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ trim($ticket->assigned_to_name ?? 'No notes submitted by technician.') }}</p>
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}" class="space-y-4">
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

                                        @error('technical_notes')
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
                                        Assign Technician / Update Notes
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Department --}}

                        @if ($ticket->status_type !== \App\Enums\StatusType::Completed)
                            <div class="rounded-2xl border border-purple-200 dark:border-purple-700 bg-white dark:bg-gray-800 p-5">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                Change Department
                            </p>

                            <form
                                method="POST"
                                action="{{ route('admin.tickets.update-department', $ticket) }}"
                                class="mt-4 space-y-4"
                            >
                                @csrf
                                @method('PUT')

                                <div>
                                    <label
                                        for="department"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Department
                                    </label>

                                    <select
                                        id="department"
                                        name="department"
                                        class="mt-2 w-full rounded-xl border border-gray-300 dark:border-gray-600
                                            bg-white dark:bg-gray-800 px-3 py-2.5
                                            text-gray-900 dark:text-gray-100 shadow-sm
                                            focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                    >
                                        <option value="">-- Select Department --</option>
                                        @foreach ($departments as $department)
                                            <option
                                                value="{{ $department->name }}"
                                                @selected(old('department', $ticket->department) === $department)
                                            >
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('department')
                                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center rounded-lg
                                        bg-transparent
                                        border border-purple-600 dark:border-purple-400
                                        px-4 py-2 text-sm font-semibold
                                        text-purple-700 dark:text-purple-400
                                        shadow-sm hover:bg-purple-50 dark:hover:bg-purple-900"
                                >
                                    Update Department
                                </button>
                            </form>
                        </div>
                        @endif

                        {{-- Status --}}
                        @php
                            $role = auth()->user()?->role instanceof \App\Enums\UserRole
                                ? auth()->user()->role->value
                                : (string) (auth()->user()?->role ?? '');

                            $canEditJargon = in_array($role, [
                                \App\Enums\UserRole::Administrator->value,
                                \App\Enums\UserRole::Controller->value,
                                \App\Enums\UserRole::Technician->value,
                            ], true);

                            $isNew = $ticket->status_type === \App\Enums\StatusType::New;
                            $isCompleted = $ticket->status_type === \App\Enums\StatusType::Completed;
                        @endphp

                        @if ($canEditJargon && ! $isNew && ! $isCompleted)
                            <div class="rounded-2xl border border-yellow-200 dark:yellow-gray-700 bg-white dark:bg-gray-800 p-5">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Change Pending Status</p>

                                <form method="POST" action="{{ route('admin.status-type-defaults.update', $ticket->status_type->value) }}" class="mt-3 space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <select
                                        name="status_id"
                                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5
                                            text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option class="text-center"><-- Select Pending Status --></option>
                                        @foreach(($pendingStatus[$ticket->status_type->value] ?? collect()) as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
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
                                        Update Pending Status
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Completed / Close Ticket --}}
                        @if ($ticket->status_type === \App\Enums\StatusType::InProgress)
                            <div class="rounded-2xl border border-green-200 dark:border-green-700 bg-white dark:bg-gray-800 p-5">
                                <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="completed_status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Completed/Close Ticket
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
                                        Close / Complete Ticket
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Danger zone --}}
                        <div class="rounded-2xl border border-red-200 dark:border-red-700 bg-white dark:bg-gray-800 p-5">
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
