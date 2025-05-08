<x-modal name="create-event" focusable>
    <form id="createTaskForm" enctype="multipart/form-data" class="p-6">
        @csrf
        <h2 class="mb-4 text-lg font-medium text-gray-900">Create Event</h2>

        <!-- Title -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" placeholder="Enter event title"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            <span class="text-sm text-red-500 error-title"></span>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="3" placeholder="Enter event description"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
            <span class="text-sm text-red-500 error-description"></span>
        </div>

        <!--Venue -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Venue</label>
            <input type="text" name="venue" placeholder="Enter event venue"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            <span class="text-sm text-red-500 error-venue"></span>
        </div>

        <!-- Date -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" name="date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            <span class="text-sm text-red-500 error-due_date"></span>
        </div>

        <!-- Time -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Time</label>
            <input type="time" name="time" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            <span class="text-sm text-red-500 error-due_time"></span>
        </div>

        <!-- Attachment -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Attachment</label>
            <input type="file" name="image" accept="image/*"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            <span class="text-sm text-red-500 error-attachment"></span>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end mt-6">
            <x-secondary-button @click.prevent="$dispatch('close-modal', 'create-event')">Cancel</x-secondary-button>
            <x-primary-button class="ml-3" type="submit">Create</x-primary-button>
        </div>
    </form>
</x-modal>

@push('scripts')
<script>
    window.addEventListener('close-modal', function () {
        $('#createTaskForm')[0].reset();
        $('.error-title, .error-description, .error-due_date, .error-due_time, .error-attachment').text('');
    });

    $('#createTaskForm').submit(function (e) {
        e.preventDefault();

        $('.error-title, .error-description, .error-venue, .error-due_date, .error-due_time, .error-attachment').text('');

        let isValid = true;

        if (!$('[name="title"]').val().trim()) {
            $('.error-title').text('Title is required.');
            isValid = false;
        }
        if (!$('[name="description"]').val().trim()) {
            $('.error-description').text('Description is required.');
            isValid = false;
        }
        if (!$('[name="venue"]').val().trim()) {
            $('.error-venue').text('Venue is required.');
            isValid = false;
        }
        if (!$('[name="date"]').val()) {
            $('.error-due_date').text('Date is required.');
            isValid = false;
        }
        if (!$('[name="time"]').val()) {
            $('.error-due_time').text('Time is required.');
            isValid = false;
        }

        if (!isValid) return;

        let formData = new FormData(this);

        $.ajax({
            url: '/api/events',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                Swal.fire('Success', 'Event created successfully!', 'success');
                $('#createTaskForm')[0].reset();
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: 'create-event'
                }));
                fetchTasks(); // Optional function to refresh event list
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.title) $('.error-title').text(errors.title[0]);
                    if (errors.description) $('.error-description').text(errors.description[0]);
                    if (errors.venue) $('.error-venue').text(errors.venue[0]);
                    if (errors.date) $('.error-due_date').text(errors.date[0]);
                    if (errors.time) $('.error-due_time').text(errors.time[0]);
                    if (errors.attachment) $('.error-attachment').text(errors.attachment[0]);
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            }
        });
    });
</script>
@endpush
