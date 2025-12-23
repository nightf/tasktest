<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Task') }}
            </h2>

            <a href="{{ route('tasks.index') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                    hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6">
                        @csrf

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Title</label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600
                                    bg-white dark:bg-gray-700
                                    text-gray-900 dark:text-gray-100
                                    focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror"
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Description</label>
                            <textarea
                                name="description"
                                rows="4"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600
                                    bg-white dark:bg-gray-700
                                    text-gray-900 dark:text-gray-100
                                    focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select
                                name="status"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600
                                    bg-white dark:bg-gray-700
                                    text-gray-900 dark:text-gray-100 @error('status') border-red-500 @enderror">
                                <option value="pending" @selected(old('status') === 'pending')>Pending</option>
                                <option value="in_progress" @selected(old('status') === 'in_progress')>In Progress</option>
                                <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Due Date --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Due Date</label>
                            <input
                                type="date"
                                name="due_date"
                                value="{{ old('due_date') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600
                                    bg-white dark:bg-gray-700
                                    text-gray-900 dark:text-gray-100 @error('due_date') border-red-500 @enderror"
                            >
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div>
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2
                                    text-sm font-semibold text-white shadow-sm
                                    hover:bg-indigo-500 focus-visible:outline
                                    focus-visible:outline-2 focus-visible:outline-offset-2
                                    focus-visible:outline-indigo-600">
                                Create Task
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
