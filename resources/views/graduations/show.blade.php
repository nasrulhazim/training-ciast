<x-layouts::app :title="$graduation->title">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                <a href="{{ route('graduations.index') }}" class="hover:text-gray-700 dark:hover:text-neutral-200">
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
            <div
                class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <div
            class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                    {{ $graduation->title }}
                </h2>
                <dl class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Ceremony date
                        </dt>
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
                                    'draft' =>
                                        'bg-slate-50 text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30',
                                    'open' =>
                                        'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30',
                                    'closed' =>
                                        'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30',
                                ];
                            @endphp
                            <span
                                class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusStyles[$graduation->status] }}">
                                {{ ucfirst($graduation->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="px-6 py-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-neutral-100">
                        Students ({{ $students->total() }})
                    </h3>

                    <form method="GET" action="{{ route('graduations.show', $graduation) }}"
                        class="flex gap-2 flex-1">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search name, IC, email, matric…"
                            class="rounded border-gray-300 text-sm w-full max-w-sm">
                        <button class="bg-slate-600 text-white px-3 py-2 rounded text-sm">Search</button>

                        @if (request('search') || request('status'))
                            <a href="{{ route('graduations.show', $graduation) }}"
                            class="text-sm text-slate-600 self-center">Clear</a>
                        @endif
                    </form>

                    @can('create', App\Models\Student::class)
                        <div class="flex flex-wrap items-center gap-2">
                            <form method="POST" action="{{ route('graduations.students.import', $graduation) }}"
                                enctype="multipart/form-data" class="inline-flex items-center gap-2">
                                @csrf
                                <input type="file" name="csv" accept=".csv,text/csv" required
                                    class="block text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200 dark:text-neutral-300 dark:file:bg-neutral-800 dark:file:text-neutral-200" />
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-slate-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-slate-700">
                                    Import CSV
                                </button>
                            </form>

                            <a href="{{ route(
                                'graduations.students.export',
                                array_filter([
                                    'graduation' => $graduation,
                                    'search' => request('search'),
                                    'status' => request('status'),
                                ]),
                            ) }}"
                                class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-emerald-700">
                                Export CSV
                            </a>

                            <a href="{{ route('graduations.students.create', $graduation) }}"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                                + Add student
                            </a>
                        </div>
                    @endcan
                </div>

                @error('csv')
                    <p class="mt-2 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror

                @php
                    $statuses = [
                        '' => ['label' => 'All', 'class' => 'bg-slate-100 text-slate-700'],
                        'verified' => ['label' => 'Verified', 'class' => 'bg-green-100 text-green-700'],
                        'pending' => ['label' => 'Pending review', 'class' => 'bg-amber-100 text-amber-700'],
                        'not_paid' => ['label' => 'Not paid', 'class' => 'bg-slate-100 text-slate-600'],
                    ];
                    $current = request('status', '');
                @endphp

                <div class="flex gap-2 mb-4">
                    @foreach ($statuses as $value => $cfg)
                        <a href="{{ route(
                            'graduations.show',
                            array_filter([
                                'graduation' => $graduation,
                                'status' => $value ?: null,
                                'search' => request('search'),
                            ]),
                        ) }}"
                            class="px-3 py-1 text-xs rounded {{ $cfg['class'] }}
                  {{ $current === $value ? 'ring-2 ring-indigo-500' : '' }}">
                            {{ $cfg['label'] }}
                        </a>
                    @endforeach
                </div>

                @php
                    $sort = request('sort', 'created_at');
                    $direction = request('direction', 'desc');
                    $sortLink = function (string $column, string $label) use ($sort, $direction) {
                        $isActive = $sort === $column;
                        $newDirection = $isActive && $direction === 'asc' ? 'desc' : 'asc';
                        $arrow = $isActive ? ($direction === 'asc' ? '▲' : '▼') : '';
                        $url = url()->current() . '?' . http_build_query(array_merge(
                            request()->except(['sort', 'direction', 'page']),
                            ['sort' => $column, 'direction' => $newDirection],
                        ));
                        return '<a href="' . $url . '" class="hover:underline">' . e($label) . ' ' . $arrow . '</a>';
                    };
                @endphp

                <div class="mt-3 overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">


                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">
                                    {!! $sortLink('name', 'Name') !!}</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">
                                    {!! $sortLink('ic', 'IC') !!}</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">
                                    {!! $sortLink('matric_card', 'Matric') !!}</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">
                                    Payment</th>
                                <th
                                    class="px-4 py-2 text-right text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-neutral-400">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @forelse ($students as $student)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/40">
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-neutral-100">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-neutral-400">
                                        {{ $student->ic }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-neutral-400">
                                        {{ $student->matric_card }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if ($student->isVerified())
                                            <span
                                                class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30">
                                                Verified
                                            </span>
                                        @elseif ($student->hasPaid())
                                            <span
                                                class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">
                                                Pending review
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-medium text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30">
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
                                    <td colspan="5"
                                        class="px-4 py-6 text-center text-sm text-gray-500 dark:text-neutral-400">
                                        @if (request('search'))
                                            No students match "{{ request('search') }}".
                                        @else
                                            No students registered for this graduation yet.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $students->links() }}
                </div>
            </div>
        </div>

    </div>
</x-layouts::app>
