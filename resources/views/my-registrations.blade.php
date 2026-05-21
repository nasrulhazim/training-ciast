<x-layouts::app :title="__('My registrations')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div>
            <h1 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                {{ __('My registrations') }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-neutral-400">
                {{ $registrations->count() }} {{ Str::plural('registration', $registrations->count()) }} on file.
            </p>
        </div>

        @forelse ($registrations as $r)
            <div class="flex flex-col gap-3 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="text-base font-semibold text-gray-900 dark:text-neutral-100">
                        {{ $r->graduation->title }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-neutral-400">
                        {{ $r->graduation->ceremony_date->format('d M Y') }}
                    </div>
                    <div class="mt-2">
                        @if ($r->isVerified())
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30">
                                Verified
                            </span>
                        @elseif ($r->hasPaid())
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">
                                Pending review
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-medium text-slate-700 ring-1 ring-slate-600/20 dark:bg-slate-500/10 dark:text-slate-300 dark:ring-slate-500/30">
                                Not paid
                            </span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('graduations.students.show', [$r->graduation, $r]) }}"
                    class="inline-flex items-center self-start rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700 sm:self-auto">
                    View / upload receipt
                </a>
            </div>
        @empty
            <p class="text-sm text-gray-600 dark:text-neutral-300">
                You have no registrations yet.
            </p>
        @endforelse

    </div>
</x-layouts::app>
