@extends('layout.admin')
@section('content')
    <div class="card card-primary">
        <div class="card-header">Controll Website Settings</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <p>
                map => [
                'user_dashboard_index_note' => 'exists : on user dashboard index'
                ]
            </p>
            <form action="{{ route('admin.wsettings.save') }}" method="post">
                @csrf
                <label for="codename" class="form-label"> position </label>
                <input type="text" id="codename" class="form-control" name="position"
                    placeholder="use consistent terminology plz">
                <div class="form-group">
                    <label for="arabic_content">Arabic Content</label>
                    <textarea id="arabic_content" class="form-control" name="arabic_content" rows="3">
                        <div
                            class="alert alert-primary"
                            role="alert"
                        >
                            <h4 class="alert-heading">Alert Heading</h4>
                            <p>Alert Content</p>
                            <hr />
                            <p class="mb-0">Alert Description</p>
                        </div>
                        
                    </textarea>
                </div>
                <div class="d-grid gap-2 mt-2">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
    @if ($message = Session::get('success_update'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div id="feedBack"></div>
    <table class="table table-bordered mt-3">
        <tr>
            <th>#ID</th>
            <th>Position</th>
            <th>Arabic Content</th>
            <th>Action</th>
        </tr>
        @if ($websiteSettings->isEmpty())
            <tr>
                <td colspan="3">
                    <div class="alert alert-warning" role="alert">
                        No entries yet
                    </div>
                </td>
            </tr>
        @else
            @foreach ($websiteSettings as $entry)
                <tr>
                    <td id="positionEl_{{ $entry->id }}">{{ $entry->position }}</td>
                    <td id="arabic_contentEl_{{ $entry->id }}">{{ $entry->arabic_content }}</td>
                    <td id="actionBtnsEl_{{ $entry->id }}">
                        <div class="gap-2 d-flex justify-content-center">
                            <button class="btn btn-info" onclick="edit({{ $entry->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pen" viewBox="0 0 16 16">
                                    <path
                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                </svg>
                            </button>
                            <form id="deleteForm" action="{{ route('admin.wsettings.delete') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $entry->id }}">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function edit(id) {
            const positionEl = document.getElementById('positionEl_' + id);
            const arabic_contentEl = document.getElementById('arabic_contentEl_' + id);
            const actionBtnsEl = document.getElementById('actionBtnsEl_' + id);
            const prev_positionValue = positionEl.innerText;
            const prev_contentValue = arabic_contentEl.innerText;

            // Setting input with previous data and changing action button to save
            positionEl.innerHTML = `
        <input type="text" id="new_positionValue_${id}" value="${prev_positionValue}">
    `;
            arabic_contentEl.innerHTML = `
        <textarea class="form-control" id="new_contentValue_${id}">${prev_contentValue}</textarea>
    `;
            actionBtnsEl.innerHTML = `
            <div class="d-flex gap-2 justify-content-center">
        <button class="btn btn-success" onclick="save(${id})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
  <path d="M11 2H9v3h2z"/>
  <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
</svg></button>
</div>
    `;
        }

        function save(id) {
            const positionEl = document.getElementById('new_positionValue_' + id);
            const arabic_contentEl = document.getElementById('new_contentValue_' + id);

            // Check if elements exist
            if (!positionEl || !arabic_contentEl) {
                alert('Error: Form fields not found.');
                return;
            }

            const postData = {
                id: id,
                position: positionEl.value,
                arabic_content: arabic_contentEl.value
            };

            // Sending POST request
            fetch('{{ route('admin.wsettings.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // For Laravel CSRF protection
                    },
                    body: JSON.stringify(postData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response Data:', data); // Debugging: log the full response
                    if (data.status === 'success') {
                        alert('Success: ' + data.message); // Handle success
                        window.location.reload();
                    } else if (data.status === 'error' && data.errors) {
                        // Handle validation errors
                        let errorMessage = 'Validation errors:\n';
                        for (const [field, messages] of Object.entries(data.errors)) {
                            errorMessage += `${field}: ${messages.join(', ')}\n`;
                        }
                        alert(errorMessage); // Display validation errors
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error')); // Handle other errors
                    }
                })
                .catch((error) => {
                    console.error('Fetch Error:', error); // Handle fetch error
                    alert('Error: ' + error.message);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            const deleteForm = document.getElementById('deleteForm');

            confirmDeleteButton.addEventListener('click', function() {
                deleteForm.submit(); // Submit the form when user confirms
            });
        });
    </script>
@endsection
