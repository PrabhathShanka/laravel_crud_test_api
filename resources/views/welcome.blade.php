<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script></script>
    @endif
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div
        class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <div class="w-full lg:w-[438px] lg:ml-0 -ml-8 lg:-mt-[6.6rem] -mt-[4.9rem]">
                <div
                    class="bg-white dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] rounded-t-lg lg:rounded-t-none lg:rounded-tl-lg lg:rounded-r-lg p-6 lg:p-8">
                    <h2 class="text-sm font-medium mb-6 dark:text-[#EDEDEC]">Upcoming Events</h2>

                    <div id="events-container" class="space-y-4">
                        <!-- Events will be loaded here dynamically -->
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Loading events...</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- View Event Modal -->
    <div id="event-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white dark:bg-[#161615] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-[#161615] text-base font-medium text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-50 dark:hover:bg-[#1f1f1e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        id="close-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Registration Modal -->
    <div id="registration-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block">
            <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block bg-white dark:bg-[#161615] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-md w-full p-6">
                <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-white">Event Registration</h3>
                <form id="registration-form">
                    <input type="hidden" name="event_id" id="register-event-id">
                    <div class="mb-3">
                        <input type="text" name="name" class="w-full px-3 py-2 border rounded"
                            placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="w-full px-3 py-2 border rounded"
                            placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" class="w-full px-3 py-2 border rounded"
                            placeholder="Your Phone" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Submit</button>
                        <button type="button" class="px-4 py-2 ml-2 bg-red-600 border rounded"
                            onclick="closeRegisterForm()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const FILESYSTEM_URL = "{{ env('FILESYSTEM_URL') }}";

            // Modal elements
            const modal = document.getElementById('event-modal');
            const closeModalBtn = document.getElementById('close-modal');

            // Close modal when clicking the close button
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Close modal when clicking outside the modal content
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });

            fetch('/events/upcoming')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(events => {
                    const container = document.getElementById('events-container');

                    if (events.length === 0) {
                        container.innerHTML =
                            '<div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">No upcoming events found.</div>';
                        return;
                    }

                    container.innerHTML = events.map(event => `
                            <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm p-4 hover:border-black dark:hover:border-white transition-all">
                                <div class="flex flex-col">
                                    ${event.image ? `
                                            <div class="mb-4">
                                                <img src="${FILESYSTEM_URL}${event.image}" class="object-cover w-full h-48 rounded-sm">
                                            </div>
                                        ` : ''}

                                    <div class="flex items-start gap-4">
                                        <div class="bg-[#fff2f2] dark:bg-[#1D0002] text-[#F53003] dark:text-[#FF4433] text-sm px-3 py-1 rounded-sm font-medium">
                                            ${formatDate(event.date)}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium dark:text-[#EDEDEC] mb-1">${event.title}</h3>
                                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2">
                                                <span class="inline-block mr-3">${formatTime(event.time)}</span>
                                                ${event.venue ? `<span>${event.venue}</span>` : ''}
                                            </p>
                                            <button
                                                onclick="viewEventDetails(${event.id})"
                                                class="text-xs px-3 py-1 bg-[#f5f5f4] dark:bg-[#262625] hover:bg-[#e5e5e4] dark:hover:bg-[#3a3a38] text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm transition-colors"
                                            >
                                                View Details
                                            </button>
                                            <button
                                                onclick="openRegisterForm(${event.id})"
                                                class="px-3 py-1 text-xs text-blue-800 transition-colors bg-blue-100 rounded-sm dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 dark:text-blue-100"
                                            >
                                                Register
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    document.getElementById('events-container').innerHTML = `
                            <div class="text-sm text-[#F53003] dark:text-[#F61500]">
                                Failed to load events. Please try again later.
                            </div>
                        `;
                });

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                });
            }

            function formatTime(timeString) {
                if (!timeString) return '';
                const [hours, minutes] = timeString.split(':');
                const date = new Date();
                date.setHours(hours);
                date.setMinutes(minutes);
                return date.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
        });

        // Global function to view event details
        function viewEventDetails(eventId) {
            fetch(`/events/${eventId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(event => {
                    const FILESYSTEM_URL = "{{ env('FILESYSTEM_URL') }}";
                    const modal = document.getElementById('event-modal');

                    // Populate modal with event data
                    document.getElementById('modal-title').textContent = event.title;

                    const modalImage = document.getElementById('modal-image');
                    if (event.image) {
                        modalImage.innerHTML =
                            `<img src="${FILESYSTEM_URL}${event.image}" class="object-cover w-full h-48 mb-4 rounded-sm">`;
                    } else {
                        modalImage.innerHTML = '';
                    }

                    document.getElementById('modal-date').textContent = `Date: ${formatDate(event.date)}`;
                    document.getElementById('modal-time').textContent = `Time: ${formatTime(event.time)}`;
                    document.getElementById('modal-venue').textContent = `Venue: ${event.venue || 'Not specified'}`;
                    document.getElementById('modal-description').textContent = event.description ||
                        'No description provided.';

                    // Show modal
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching event details:', error);
                    alert('Failed to load event details. Please try again later.');
                });

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }

            function formatTime(timeString) {
                if (!timeString) return '';
                const [hours, minutes] = timeString.split(':');
                const date = new Date();
                date.setHours(hours);
                date.setMinutes(minutes);
                return date.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
        }


        function openRegisterForm(eventId) {
            document.getElementById('register-event-id').value = eventId;
            document.getElementById('registration-modal').classList.remove('hidden');
        }

        function closeRegisterForm() {
            document.getElementById('registration-modal').classList.add('hidden');
        }

        document.getElementById('registration-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/registrations', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to submit');
                    return response.json();
                })
                .then(data => {
                    alert(data.message || 'Registration successful!');
                    closeRegisterForm();
                })
                .catch(error => {
                    console.error('Registration failed:', error);
                    alert('Failed to register. Please try again.');
                });
        });
    </script>
</body>

</html>
