<x-layouts::app :title="__('New Graduation')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                <a href="{{ route('graduations.index') }}"
                   class="hover:text-gray-700 dark:hover:text-neutral-200">
                    Graduations
                </a>
                <span aria-hidden="true">/</span>
                <span class="font-medium text-gray-900 dark:text-neutral-100">
                    New graduation
                </span>
            </div>

            <a href="{{ route('graduations.index') }}"
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800">
                Cancel
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                    Add a new graduation
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                    Set the ceremony date and registration fee. Status controls whether students can register.
                </p>
            </div>

            <form method="POST" action="{{ route('graduations.store') }}" class="space-y-6 px-6 py-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                        Title
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           autofocus
                           class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('title') border-rose-500 @enderror" />
                    @error('title')
                        <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="ceremony_date" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            Ceremony date
                        </label>
                        <input type="date"
                               id="ceremony_date"
                               name="ceremony_date"
                               value="{{ old('ceremony_date') }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('ceremony_date') border-rose-500 @enderror" />
                        @error('ceremony_date')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fee" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            Fee (RM)
                        </label>
                        <input type="number"
                               id="fee"
                               name="fee"
                               step="0.01"
                               min="0"
                               value="{{ old('fee') }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('fee') border-rose-500 @enderror" />
                        @error('fee')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                        Status
                    </label>
                    <select id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('status') border-rose-500 @enderror">
                        @foreach (['draft', 'open', 'closed'] as $s)
                            <option value="{{ $s }}" @selected(old('status', 'draft') === $s)>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-neutral-200 pt-5 dark:border-neutral-700">
                    <a href="{{ route('graduations.index') }}"
                       class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                        Create graduation
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layouts::app>
