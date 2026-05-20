<x-layouts::app :title="__('Edit Student')">
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
                <a href="{{ route('graduations.students.show', [$graduation, $student]) }}"
                   class="hover:text-gray-700 dark:hover:text-neutral-200">
                    {{ $student->name }}
                </a>
                <span aria-hidden="true">/</span>
                <span class="font-medium text-gray-900 dark:text-neutral-100">
                    Edit
                </span>
            </div>

            <a href="{{ route('graduations.students.show', [$graduation, $student]) }}"
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800">
                Cancel
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                    Edit {{ $student->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                    Update personal details or upload your payment receipt to register payment.
                </p>
            </div>

            <form method="POST"
                  action="{{ route('graduations.students.update', [$graduation, $student]) }}"
                  enctype="multipart/form-data"
                  class="space-y-6 px-6 py-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            Name
                        </label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $student->name) }}" required autofocus
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('name') border-rose-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ic" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            IC number
                        </label>
                        <input type="text" id="ic" name="ic"
                               value="{{ old('ic', $student->ic) }}" required maxlength="12"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('ic') border-rose-500 @enderror" />
                        @error('ic')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            Email
                        </label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $student->email) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('email') border-rose-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="matric_card" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            Matric card
                        </label>
                        <input type="text" id="matric_card" name="matric_card"
                               value="{{ old('matric_card', $student->matric_card) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('matric_card') border-rose-500 @enderror" />
                        @error('matric_card')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                            Phone
                        </label>
                        <input type="text" id="phone" name="phone"
                               value="{{ old('phone', $student->phone) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 @error('phone') border-rose-500 @enderror" />
                        @error('phone')
                            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-neutral-200 pt-5 dark:border-neutral-700">
                    <label for="payment_receipt" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">
                        Payment receipt
                    </label>
                    <p class="mt-1 text-xs text-gray-500 dark:text-neutral-400">
                        PDF / JPG / PNG, max 2 MB. Uploading a new file stamps the payment time automatically.
                    </p>
                    <input type="file" id="payment_receipt" name="payment_receipt"
                           accept=".pdf,image/jpeg,image/png"
                           class="mt-2 block w-full text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100 dark:text-neutral-300 dark:file:bg-indigo-500/10 dark:file:text-indigo-300" />
                    @error('payment_receipt')
                        <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror

                    @if ($student->payment_receipt)
                        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                            Current receipt:
                            <a class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                               target="_blank"
                               href="{{ Storage::url($student->payment_receipt) }}">
                                view
                            </a>
                        </p>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-neutral-200 pt-5 dark:border-neutral-700">
                    <a href="{{ route('graduations.students.show', [$graduation, $student]) }}"
                       class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                        Save changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layouts::app>
