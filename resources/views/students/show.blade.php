<x-layouts::app :title="$student->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-neutral-400">
                <a href="{{ route('graduations.index') }}"
                   class="hover:text-gray-700 dark:hover:text-neutral-200">
                    Graduations
                </a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('graduations.show', $graduation) }}"
                   class="hover:text-gray-700 dark:hover:text-neutral-200">
                    {{ $graduation->title }}
                </a>
                <span aria-hidden="true">/</span>
                <span class="font-medium text-gray-900 dark:text-neutral-100">
                    {{ $student->name }}
                </span>
            </div>

            @can('update', $student)
                <a href="{{ route('graduations.students.edit', [$graduation, $student]) }}"
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
                    {{ $student->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                    Registration for {{ $graduation->title }}.
                </p>
            </div>

            <dl class="grid grid-cols-1 gap-4 px-6 py-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">IC</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-neutral-100">{{ $student->ic }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Matric card</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-neutral-100">{{ $student->matric_card }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-neutral-100">{{ $student->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-400">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-neutral-100">{{ $student->phone }}</dd>
                </div>
            </dl>

            <div class="border-t border-neutral-200 px-6 py-5 dark:border-neutral-700">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-neutral-100">Payment</h3>

                <div class="mt-2 flex items-center gap-3">
                    @if ($student->isVerified())
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30">
                            Verified
                        </span>
                        <span class="text-sm text-gray-500 dark:text-neutral-400">
                            on {{ $student->verified_at->format('d M Y H:i') }}
                        </span>
                    @elseif ($student->hasPaid())
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">
                            Pending review
                        </span>
                        <span class="text-sm text-gray-500 dark:text-neutral-400">
                            paid {{ $student->paid_at->format('d M Y H:i') }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-medium text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30">
                            Not paid
                        </span>
                    @endif
                </div>

                @if ($student->payment_receipt)
                    <p class="mt-3 text-sm">
                        <a class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                           target="_blank"
                           href="{{ Storage::url($student->payment_receipt) }}">
                            View payment receipt
                        </a>
                    </p>
                @endif

                @can('verify', $student)
                    <form method="POST"
                          action="{{ route('graduations.students.verify', [$graduation, $student]) }}"
                          class="mt-4">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-emerald-700">
                            Verify payment
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        @if (auth()->user()->isAdmin())
            @php
                $audits = App\Models\Audit::query()
                    ->where('auditable_type', App\Models\Student::class)
                    ->where('auditable_id', $student->id)
                    ->with('user')
                    ->latest()
                    ->get();
            @endphp

            @if ($audits->isNotEmpty())
                <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="px-6 py-5">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-neutral-100">Audit log</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            @foreach ($audits as $audit)
                                <li class="flex justify-between border-b border-neutral-200 pb-2 dark:border-neutral-700">
                                    <span class="text-gray-700 dark:text-neutral-200">
                                        <strong>{{ ucfirst($audit->action) }}</strong>
                                        by {{ $audit->user?->name ?? 'system' }}
                                        @if (($audit->changes['via'] ?? null) === 'bulk')
                                            <span class="text-xs text-slate-500 dark:text-neutral-400">(bulk)</span>
                                        @endif
                                    </span>
                                    <span class="text-slate-500 dark:text-neutral-400">{{ $audit->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif

    </div>
</x-layouts::app>
