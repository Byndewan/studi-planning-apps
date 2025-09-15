@props(['name', 'value' => null, 'placeholder' => 'Select date', 'required' => false])

<div x-data="{
        value: @entangle($attributes->wire('model')),
        picker: null,
        init() {
            this.picker = flatpickr(this.$refs.input, {
                dateFormat: 'Y-m-d',
                allowInput: true,
                onChange: (selectedDates, dateStr) => {
                    this.value = dateStr;
                }
            });

            if (this.value) {
                this.picker.setDate(this.value);
            }
        }
    }"
    class="relative">
    <input
        x-ref="input"
        type="text"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        @class([
            'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500',
            'pr-10' => !$attributes->has('readonly')
        ])
        {{ $attributes->except('wire:model') }}
    >
    @unless($attributes->has('readonly'))
    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
        </svg>
    </div>
    @endunless
</div>
