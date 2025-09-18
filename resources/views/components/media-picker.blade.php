@props(['name', 'value' => null, 'accept' => 'image/*', 'multiple' => false])

<div x-data="{
    files: [],
    fileUrls: [],
    addFiles(event) {
        const newFiles = Array.from(event.target.files);
        this.files = [...this.files, ...newFiles];

        newFiles.forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.fileUrls.push(e.target.result);
            };
            reader.readAsDataURL(file);
        });

        this.$dispatch('media-selected', this.files);
    },
    removeFile(index) {
        this.files.splice(index, 1);
        this.fileUrls.splice(index, 1);
        this.$dispatch('media-selected', this.files);
    }
}" class="space-y-4">
    <div class="flex items-center justify-center w-full">
        <label for="{{ $name }}" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-300 group">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 20 16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500 group-hover:text-gray-600 transition-colors">
                    <span class="font-semibold">Klik untuk unggah</span> atau drag and drop
                </p>
                <p class="text-xs text-gray-400">{{ $accept }}</p>
            </div>
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="file"
                class="hidden"
                accept="{{ $accept }}"
                {{ $multiple ? 'multiple' : '' }}
                @change="addFiles($event)"
            >
        </label>
    </div>

    <template x-if="fileUrls.length > 0">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <template x-for="(url, index) in fileUrls" :key="index">
                <div class="relative group">
                    <img :src="url" class="w-full h-24 object-cover rounded-xl border border-gray-200 shadow-sm group-hover:shadow-md transition-all duration-300">
                    <button
                        type="button"
                        @click="removeFile(index)"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600 hover:scale-110"
                    >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>

<style>
    .group:hover .border-gray-300 {
        border-color: #2563eb;
    }

    .group:hover .bg-gray-50 {
        background-color: #f0f9ff;
    }
</style>
