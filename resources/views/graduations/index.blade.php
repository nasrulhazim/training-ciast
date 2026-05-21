<x-layouts::app :title="__('Graduations')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                    Graduations
                </h1>
                <p class="text-sm text-gray-500 dark:text-neutral-400">
                    {{ $graduations->total() }} {{ Str::plural('graduation', $graduations->total()) }} on file.
                </p>
            </div>

            @can('create', App\Models\Graduation::class)
                <a href="{{ route('graduations.create') }}"
                   class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                    + New graduation
                </a>
            @endcan
        </div>

        @if (session('status'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" action="{{ route('graduations.index') }}" class="flex gap-2 items-center">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by title…"
                class="rounded border-gray-300 text-sm w-full max-w-md dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-100">
            <button class="inline-flex items-center rounded-md bg-slate-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-slate-700">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('graduations.index') }}"
                    class="text-sm text-slate-600 dark:text-neutral-300 self-center hover:underline">
                    Clear
                </a>
            @endif
        </form>

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Fee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Students</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @php
                        $statusStyles = [
                            'draft'  => 'bg-slate-50 text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30',
                            'open'   => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30',
                            'closed' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30',
                        ];
                    @endphp

                    @forelse ($graduations as $g)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-neutral-100">
                                <a href="{{ route('graduations.show', $g) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $g->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-neutral-400">
                                {{ $g->ceremony_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-neutral-400">
                                RM {{ number_format((float) $g->fee, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusStyles[$g->status] }}">
                                    {{ ucfirst($g->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-neutral-400">
                                {{ $g->students_count }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('graduations.show', $g) }}"
                                       class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        View
                                    </a>
                                    @can('update', $g)
                                        <span class="text-neutral-300 dark:text-neutral-600">|</span>
                                        <a href="{{ route('graduations.edit', $g) }}"
                                           class="text-gray-700 hover:text-gray-900 dark:text-neutral-300 dark:hover:text-neutral-100">
                                            Edit
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-neutral-400">
                                @if (request('search'))
                                    No graduations match "{{ request('search') }}".
                                @else
                                    No graduations yet.
                                    @can('create', App\Models\Graduation::class)
                                        <a href="{{ route('graduations.create') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Add the first one
                                        </a>.
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $graduations->links() }}</div>

    </div>
</x-layouts::app>
