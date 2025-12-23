<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tasks') }}
            </h2>

            <a href="{{ route('tasks.create') }}"
               class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                      hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Add Task +
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)" x-cloak>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Loading State -->
            <template x-if="loading">
                <div class="flex justify-center py-20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 animate-spin dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </template>

            <!-- Actual Table -->
            <div x-show="!loading" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-2">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search by title..."
                                    value="{{ $search ?? '' }}"
                                    class="rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                                        text-gray-900 dark:text-gray-100 px-3 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                >
                                <button type="submit" class="px-3 py-1 rounded bg-indigo-600 text-white hover:bg-indigo-500">
                                    Search
                                </button>
                            </form>
                            <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                <thead>
                                    <tr>
                                        <th class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">Title</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Description</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('tasks.index', ['sort' => 'status', 'direction' => $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                                Status
                                                @if($sortField === 'status')
                                                    {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('tasks.index', ['sort' => 'due_date', 'direction' => $sortField === 'due_date' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                                Due Date
                                                @if($sortField === 'due_date')
                                                    {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                                    @forelse ($tasks as $task)
                                        <tr class="
                                            @if($task->status === 'pending') bg-yellow-100
                                            @elseif($task->status === 'in-progress') bg-blue-100
                                            @elseif($task->status === 'completed') bg-green-100
                                            @endif
                                        ">
                                            <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 dark:text-black">
                                                {{ $task->title }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-black">
                                                {{ $task->description }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-black">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-black">
                                                {{ $task->due_date?->format('Y-m-d') ?? '-' }}
                                            </td>
                                            <td class="py-4 pr-4 pl-3 text-sm font-medium whitespace-nowrap sm:pr-0">
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    Edit
                                                </a>
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No tasks found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
