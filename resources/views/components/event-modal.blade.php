<!-- resources/views/components/event-modal.blade.php -->
<div id="event-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-[#161615] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 id="modal-title" class="text-lg leading-6 font-medium dark:text-[#EDEDEC] mb-2"></h3>
                        <div id="modal-image" class="mb-4"></div>
                        <div id="modal-date" class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-1"></div>
                        <div id="modal-time" class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-1"></div>
                        <div id="modal-venue" class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-4"></div>
                        <div id="modal-description" class="text-sm text-[#706f6c] dark:text-[#A1A09A]"></div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-[#161615] text-base font-medium text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-50 dark:hover:bg-[#1f1f1e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="close-modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
