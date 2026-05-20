<x-layouts::app :title="$graduation->title">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                <a href="{{ route('graduations.index') }}"
                   class="hover:text-gray-700 dark:hover:text-neutral-200">
                    Graduations
                </a>
                <span aria-hidden="true">/</span>
                <span class="font-medium text-gray-900 dark:text-neutral-100">
                    {{ $graduation->title }}
                </span>
            </div>

            @can('update', $graduation)
                <a href="{{ route('graduations.edit', $graduation) }}"
                   class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                    Edit
                </a>
            @endcan
        </div>

        @if (session('status'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                    {{ $graduation->title }}
                </h2>
                <dl class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Ceremony date</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-neutral-100">
                            {{ $graduation->ceremony_date->format('d M Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Fee</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-neutral-100">
                            RM {{ number_format((float) $graduation->fee, 2) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Status</dt>
                        <dd class="mt-1 text-sm">
                            @php
                                $statusStyles = [
                                    'draft'  => 'bg-slate-50 text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30',
                                    'open'   => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30',
                                    'closed' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusStyles[$graduation->status] }}">
                                {{ ucfirst($graduation->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="px-6 py-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-neutral-100">
                        Students ({{ $graduation->students->count() }})
                    </h3>
                    @can('create', App\Models\Student::class)
                        <a href="{{ route('graduations.students.create', $graduation) }}"
                           class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                            + Add student
                        </a>
                    @endcan
                </div>

                <div class="mt-3 overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Matric</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">Payment</th>
                                <th class="px-4 py-2 text-right text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @forelse ($graduation->students as $student)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40">
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-neutral-100">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-neutral-400">
                                        {{ $student->matric_card }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if ($student->isVerified())
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30">
                                                Verified
                                            </span>
                                        @elseif ($student->hasPaid())
                                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">
                                                Pending review
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-medium text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30">
                                                Not paid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right text-sm">
                                        <div class="inline-flex items-center gap-2">
                                            @can('view', $student)
                                                <a href="{{ route('graduations.students.show', [$graduation, $student]) }}"
                                                   class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    View
                                                </a>
                                            @endcan

                                            @can('delete', $student)
                                                <span class="text-neutral-300 dark:text-neutral-600">|</span>
                                                <form method="POST"
                                                      action="{{ route('graduations.students.destroy', [$graduation, $student]) }}"
                                                      onsubmit="return confirm('Remove {{ $student->name }}?');"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300">
                                                        Remove
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-neutral-400">
                                        No students registered for this graduation yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-layouts::app>
