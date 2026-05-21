<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        @php
            $cards = [
                ['label' => 'Graduations', 'value' => $totals['graduations'], 'class' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/30'],
                ['label' => 'Students', 'value' => $totals['students'], 'class' => 'bg-slate-50 text-slate-700 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30'],
                ['label' => 'Verified', 'value' => $totals['verified'], 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30'],
                ['label' => 'Pending', 'value' => $totals['pending'], 'class' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30'],
                ['label' => 'Not paid', 'value' => $totals['not_paid'], 'class' => 'bg-rose-50 text-rose-700 ring-rose-600/20 dark:bg-rose-500/10 dark:text-rose-300 dark:ring-rose-500/30'],
            ];
        @endphp

        <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
            @foreach ($cards as $c)
                <div class="rounded-xl p-5 ring-1 {{ $c['class'] }}">
                    <div class="text-xs uppercase tracking-wide">{{ $c['label'] }}</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $c['value'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-neutral-200 px-6 py-4 dark:border-neutral-700">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-neutral-100">Latest graduations</h3>
            </div>

            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Verified</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Pending review</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Not paid</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($graduations as $g)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40">
                            <td class="px-6 py-3 text-sm">
                                <a href="{{ route('graduations.show', $g) }}"
                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    {{ $g->title }}
                                </a>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-neutral-100">{{ $g->students_count }}</td>
                            <td class="px-6 py-3 text-sm text-emerald-700 dark:text-emerald-300">{{ $g->verified_count }}</td>
                            <td class="px-6 py-3 text-sm text-amber-700 dark:text-amber-300">{{ $g->pending_count }}</td>
                            <td class="px-6 py-3 text-sm text-slate-600 dark:text-neutral-400">{{ $g->not_paid_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-neutral-400">
                                No graduations yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-layouts::app>
