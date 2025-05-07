@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/contact.css') }}">


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
    <div class="container tab-bg mt-4 mb-4">
        <h5>Contact Us</h5>
        <form method="POST" action="{{url('support-ticket')}}" enctype="multipart/form-data">
            @csrf
            <!-- Title of Message -->
            <div class="mb-3">
                <label class="form-label">Title of Message</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title">
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="5" placeholder="Enter your message"></textarea>
            </div>

            <!-- Priority and Upload Image -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Priority</label>
                    <select class="form-select" name="priority">
                        <option selected>Select Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <label class="form-label me-2">Upload Image:</label>
                    <input type="file" name="supporting_image">
                    <!-- Custom Upload Icon -->
                    <!-- <div class="custom-upload-icon" onclick="document.getElementById('imageUpload').click()">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <input type="file" name="supporting_image" class="d-none" id="imageUpload" onchange="displayFileName()">
                                <span class="ms-3" id="fileName">No file chosen</span>
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2 rounded-circle" onclick="removeFile()" style="display: none;" id="removeButton">
                                    <i class="fa-solid fa-xmark"></i>
                                </button> -->
                </div>
            </div>

            <!-- Send Button -->
            <button type="submit" class="btn btn-outline-dark">Send</button>
        </form>
    </div>

    <div class="tab-bg">
        <div class="table-container">

            <table id="example" class="dataTable display table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Ticket Number</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Priority</th>
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
                        <td>{{ $ticket->message }}</td>
                        <td>{{ $ticket->priority }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>
                            @if ($ticket->supporting_image)
                            <img src="{{ asset('support_ticket_images/'.$ticket->supporting_image) }}" alt="Supporting Image" width="100">
                            @else
                            No Image
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No support tickets found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
        // Function to display file name
        function displayFileName() {
            var input = document.getElementById('imageUpload');
            var fileName = document.getElementById('fileName');
            var removeButton = document.getElementById('removeButton');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
                removeButton.style.display = 'inline-block';
            } else {
                fileName.textContent = 'No file chosen';
                removeButton.style.display = 'none';
            }
        }

        // Function to remove selected file
        function removeFile() {
            var input = document.getElementById('imageUpload');
            input.value = "";
            displayFileName();
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
    </script>




    @stop