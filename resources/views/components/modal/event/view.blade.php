<div x-data="{ open: false }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto"
    x-on:open-modal.window="if ($event.detail === 'view-event') open = true"
    x-on:close-modal.window="if ($event.detail === 'view-event') open = false" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl">
            <div class="flex items-start justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800" id="view_title"></h2>
                <button @click.prevent="$dispatch('close-modal', 'view-event')"
                    class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4">
                <h3 class="mb-1 text-sm font-medium text-gray-700">Description</h3>
                <p class="text-gray-600" id="view_description"></p>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                <div>
                    <h3 class="mb-1 text-sm font-medium text-gray-700">Venue</h3>
                    <p class="text-gray-600" id="view_venue"></p>
                </div>
                <div>
                    <h3 class="mb-1 text-sm font-medium text-gray-700">Date</h3>
                    <p class="text-gray-600" id="view_date"></p>
                </div>
                <div>
                    <h3 class="mb-1 text-sm font-medium text-gray-700">Time</h3>
                    <p class="text-gray-600" id="view_time"></p>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="mb-1 text-sm font-medium text-gray-700">Image</h3>
                <div id="view_image" class="mt-2">
                    <img id="event_image" src="" alt="Event Image" class="h-auto max-w-full rounded-lg">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button @click.prevent="$dispatch('close-modal', 'view-event')">
                    Close
                </x-secondary-button>
            </div>
        </div>
    </div>
</div>
