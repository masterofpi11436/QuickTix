<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statuses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Status List</h3>

                        <a
                            href="{{ route('admin.statuses.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-md text-sm"
                        >
                            Create Status
                        </a>
                    </div>

                    <div class="overflow-x-auto">

                        {{-- TABLE (shown on sm and up) --}}
                        <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Color
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Status Type
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($statuses as $status)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">
                                            {{ $status->name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            @if($status->color)
                                                <span class="inline-flex items-center space-x-2">
                                                    <span
                                                        class="inline-block w-3 h-3 rounded-full border border-gray-300 dark:border-gray-600"
                                                        style="background-color: {{ $status->color }};"
                                                    ></span>
                                                    <span class="text-sm text-gray-700 dark:text-gray-200">
                                                        {{ $status->color }}
                                                    </span>
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400 dark:text-gray-500">
                                                    N/A
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3">
                                            @switch($status->status_type)
                                                @case(\App\Enums\StatusType::Default)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100">
                                                        Default
                                                    </span>
                                                    @break

                                                @case(\App\Enums\StatusType::InProgress)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-200 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                                                        In Progress
                                                    </span>
                                                    @break

                                                @case(\App\Enums\StatusType::Completed)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                        Completed
                                                    </span>
                                                    @break

                                                @default
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100">
                                                        {{ ucfirst(str_replace('_', ' ', $status->status_type->value ?? 'unknown')) }}
                                                    </span>
                                            @endswitch
                                        </td>

                                        <td class="px-4 py-3 space-x-3">
                                            <a
                                                href="{{ route('admin.statuses.show', $status) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:underline"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('admin.statuses.edit', $status) }}"
                                                class="text-yellow-600 dark:text-yellow-400 hover:underline"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.statuses.destroy', $status) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Delete this status?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No statuses found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- MOBILE CARD VIEW (only on < sm) --}}
                        <div class="sm:hidden space-y-4">
                            @forelse ($statuses as $status)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $status->name }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Color:</span>
                                        <span class="flex items-center space-x-2">
                                            @if($status->color)
                                                <span
                                                    class="inline-block w-3 h-3 rounded-full border border-gray-300 dark:border-gray-600"
                                                    style="background-color: {{ $status->color }};"
                                                ></span>
                                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $status->color }}
                                                </span>
                                            @else
                                                <span class="font-medium text-gray-500 dark:text-gray-400">
                                                    N/A
                                                </span>
                                            @endif
                                        </span>
                                    </div>

                                    <div class="flex justify-between mb-3">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Status Type:</span>
                                        <span>
                                            @switch($status->status_type)
                                                @case(\App\Enums\StatusType::Default)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100">
                                                        Default
                                                    </span>
                                                    @break

                                                @case(\App\Enums\StatusType::InProgress)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-200 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                                                        In Progress
                                                    </span>
                                                    @break

                                                @case(\App\Enums\StatusType::Completed)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                        Completed
                                                    </span>
                                                    @break

                                                @default
                                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100">
                                                        {{ ucfirst(str_replace('_', ' ', $status->status_type->value ?? 'unknown')) }}
                                                    </span>
                                            @endswitch
                                        </span>
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <a
                                            href="{{ route('admin.statuses.show', $status) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:underline"
                                        >
                                            View
                                        </a>
                                        <a
                                            href="{{ route('admin.statuses.edit', $status) }}"
                                            class="text-yellow-600 dark:text-yellow-400 hover:underline"
                                        >
                                            Edit
                                        </a>
                                        <form
                                            action="{{ route('admin.statuses.destroy', $status) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this status?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="text-red-600 dark:text-red-400 hover:underline"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400">
                                    No statuses found.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $statuses->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
