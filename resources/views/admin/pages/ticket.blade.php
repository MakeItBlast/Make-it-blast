@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/ticket.css') }}">
@stop


@section('content')

@if ($errors->any())
<div class="overlay" id="errorOverlay" data-close="true"> <!-- Overlay with data attribute -->
    <div class="popup-box error-box" id="errorBox" data-close="false">
        <span class="close-btn" onclick="closeErrorBox()">&times;</span>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if (session('success'))
<div class="overlay" id="successOverlay" data-close="true"> <!-- Overlay with data attribute -->
    <div class="popup-box success-box" id="successBox" data-close="false">
        <button class="close-btn" onclick="closePopup()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="message-content">
            <p>{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif




@if (auth()->guest())
{{-- Redirect to login page --}}
@php
header('Location: /make-it-blast');
exit();
@endphp
@endif

<!-- Page Content -->
<div class="container my-4 py-4">

    <div class="tab-bg">
        <div class="table-container">
            <h2 class="my-4">Ticket History</h2>
            <div class="table-responsive">

                <table class="dataTable table table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Ticket Number</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Priority</th>
                            <th>Issue Type</th>
                            <th>Status</th>
                            <th>Supporting Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $incr = 1; ?>
                        @forelse ($getSupportData as $ticket)
                        <tr>
                            <td>{{ $incr++ }}</td>
                            <td>{{ $ticket->ticket_id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td class="message-cell" data-full-message="{{ $ticket->message }}">
                                {{ $ticket->message }}
                            </td>
                            <td>{{ $ticket->priority }}</td>
                            <td>{{ $ticket->issueType->issue_type}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="ticket-status-toggle" data-id="{{ $ticket->id }}" {{ $ticket->status == 'open' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                @if ($ticket->supporting_image)
                                <button class="btn btn-sm btn-primary preview-button"
                                    data-image="{{ asset('support_ticket_images/'.$ticket->supporting_image) }}">
                                    <i class="fa-solid fa-magnifying-glass"></i> <span>View Attachment</span>
                                </button>
                                @else
                                No Image
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No active support tickets.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="tab-bg my-4">
        <h3 class="mb-3">Add Issue Type</h3>
        <form class="d-flex" method='post' action="{{url('store-issue-type')}}">
            @csrf
            <input type="text" class="form-control me-2" name="issue_type" value="{{$populateUpdate->issue_type ?? ''}}" placeholder="Please enter new issue type">
            <input type="hidden" name="updId" value="{{$populateUpdate->id ?? ''}}">
            <button type="submit" class="btn btn-primary">
                {{ optional($populateUpdate)->issue_type ? 'Update' : 'Save' }}
            </button>

        </form>
    </div>

    <div class="tab-bg my-4">
        <div class="table-container">
            <h3 class="mb-3">Issue Types</h3>
            <div class="table-responsive">

                <table class="dataTable table table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Issue Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $incr = 1; ?>
                        @forelse ($getIssueTypes as $types)
                        <tr>
                            <td>{{ $incr++ }}</td>
                            <td>{{ $types->issue_type}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="status-toggle" data-id="{{ $types->id }}" {{ $types->status == 'active' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <form method="post" action="{{ url('support-tickets') }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="updId" value="{{ $types->id }}">
                                        <button type="submit" class="edit-ticket">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </form>

                                    <form method="post" action="{{url('delete-issue-types')}}">
                                        @csrf
                                        <input type="hidden" name="delId" value="{{$types->id}}">
                                        <button type="submit" class="dlt-ticket">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>

                            </td>
                            @empty
                        <tr>
                            <td colspan="4">No support tickets found.</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>



<!-- modal boxes -->
<!-- Image Preview Modal -->
<div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox()">
    <span class="lightbox-close"><i class="fa-solid fa-xmark"></i></span>
    <img class="lightbox-content" id="lightboxImg">
</div>


<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    // for error and success message
    document.addEventListener('DOMContentLoaded', () => {

        // Close the popups when clicking outside the box
        document.addEventListener('click', (event) => {

            // Error box logic
            const errorOverlay = document.getElementById('errorOverlay');
            if (errorOverlay && event.target.dataset.close === "true") {
                closeErrorBox();
            }

            // Success box logic
            const successOverlay = document.getElementById('successOverlay');
            if (successOverlay && event.target.dataset.close === "true") {
                closePopup();
            }
        });
    });

    // Close error box
    function closeErrorBox() {
        const errorOverlay = document.getElementById('errorOverlay');
        if (errorOverlay) {
            errorOverlay.style.display = 'none';
        }
    }

    // Close success popup
    function closePopup() {
        const successOverlay = document.getElementById('successOverlay');
        if (successOverlay) {
            successOverlay.style.display = 'none';
        }
    }


    // for data tables

    $(document).ready(function() {
        $('.dataTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50],
            "pagingType": "simple_numbers", // Only prev/next + numbers
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>", // Next icon
                    "previous": "<i class='fas fa-chevron-left'></i>" // Previous icon
                }
            }
        });
    });

    // for trimming message in table 
    document.addEventListener("DOMContentLoaded", function() {
        const maxChars = 50; // or whatever limit you prefer
        const messageCells = document.querySelectorAll('.message-cell');

        messageCells.forEach(cell => {
            const fullMessage = cell.getAttribute('data-full-message');

            if (fullMessage.length > maxChars) {
                const shortMessage = fullMessage.substring(0, maxChars) + '...';
                cell.innerText = shortMessage;

                // Set the full message as the tooltip
                cell.setAttribute('title', fullMessage);
            }
        });
    });

    // for image preview in modal box
    document.querySelectorAll('.preview-button').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = document.getElementById('lightboxModal');
            const modalImg = document.getElementById('lightboxImg');
            modal.style.display = 'block';
            modalImg.src = this.getAttribute('data-image');
        });
    });

    function closeLightbox() {
        document.getElementById('lightboxModal').style.display = 'none';
    }

    //for status of issue type

    $(document).ready(function() {
        $('.status-toggle').on('change', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 'active' : 'inactive';

            $.ajax({
                url: "{{ url('update-issue-types') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(response) {
                    console.log('abcd', response);
                    if (response.status) {
                        alert("Status updated to " + status);
                    } else {
                        alert("Something went wrong");
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                    console.log(xhr.responseText);
                }
            });
        });
    });


    // for status of tickets

    $(document).ready(function() {
        $('.ticket-status-toggle').on('change', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 'open' : 'closed';

            $.ajax({
                url: "{{ url('update-support-status') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Status updated to " + status);
                    } else {
                        alert("Failed to update status: " + response.message);
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>


@stop