<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Event List
            </h2>
            <button x-data="" @click.prevent="$dispatch('open-modal', 'create-event')"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                + Create Event
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="eventTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Title
                                    </th>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Venue
                                    </th>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Date
                                    </th>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="eventList" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                    <div id="noEvents" class="hidden mt-4 text-center text-gray-500">No events found.</div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal.event.create')
    @endcomponent

    @component('components.modal.event.edit')
    @endcomponent

    @component('components.modal.event.view')
    @endcomponent

    @push('scripts')
        <script>
            const FILESYSTEM_URL = "{{ env('FILESYSTEM_URL') }}";

            $(document).ready(function() {
                fetchTasks();
            });

            function fetchTasks() {
                $.ajax({
                    url: '/api/events',
                    method: 'GET',
                    success: function(events) {
                        if (events.length === 0) {
                            $('#eventList').empty();
                            $('#noEvents').removeClass('hidden');
                            return;
                        }

                        $('#noEvents').addClass('hidden');
                        let html = '';
                        events.forEach(event => {
                            const status = event.status ?? 'Pending';
                            
                            html += `
                                    <tr>
                                        <td class="px-4 py-2">${event.title}</td>
                                        <td class="px-4 py-2">${event.venue ?? 'N/A'}</td>
                                        <td class="px-4 py-2">
                                         ${event.date}
                                            </td>
                                        <td class="px-4 py-2 space-x-2">
                                              <button onclick="openViewModal(${event.id})" class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="openEditModal(${event.id})" class="text-yellow-500 hover:text-yellow-700">
                                                    <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteevent(${event.id})" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>                                    </tr>
                                `;
                        });
                        $('#eventList').html(html);
                    },
                    error: function() {
                        Swal.fire('Error', 'Unable to fetch events. Please try again later.', 'error');
                    }
                });
            }

        </script>
    @endpush
</x-app-layout>
