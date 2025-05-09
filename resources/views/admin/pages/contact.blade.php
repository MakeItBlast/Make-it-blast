@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/contact.css') }}">
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

            <!-- Priority-->
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

                <!-- Issue Type -->
                <div class="col-md-4">
                    <label class="form-label">Issue Type</label>
                    <select class="form-select" name="issue_type">
                        <option>Select Issue Type</option>
                        @foreach($getIssueData as $type)
                        <option value="{{ $type->id }}">{{ $type->issue_type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Upload Image  -->
                <div class="col-md-4 d-flex align-items-end">
                    <!-- Custom Upload Icon with Label for Accessibility -->
                    <label for="imageUpload" class="custom-upload-icon" style="cursor: pointer;">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </label>

                    <!-- Hidden File Input -->
                    <input type="file" name="supporting_image" class="d-none" id="imageUpload" onchange="displayFileName()">

                    <!-- File Name Display -->
                    <span class="ms-3" id="fileName" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;">
                        No file chosen
                    </span>

                    <!-- Remove Button -->
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2 rounded-circle" onclick="removeFile()" style="display: none;" id="removeButton">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Image Preview -->
                    <img id="imagePreview" src="#" alt="Preview" style="display:none; max-height:100px; margin-left:10px;">
                </div>
            </div>

            <!-- Send Button -->
            <button type="submit" class="btn btn-success">Send</button>
        </form>
    </div>

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
                            <td>{{ $ticket->status }}</td>
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
                            <td colspan="8">No support tickets found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>



    <!--  Image preview modal from table  -->
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

        function displayFileName() {
            var input = document.getElementById('imageUpload');
            var fileName = document.getElementById('fileName');
            var removeButton = document.getElementById('removeButton');
            var preview = document.getElementById('imagePreview');

            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
                removeButton.style.display = 'inline-block';

                // Show preview if it's an image
                if (input.files[0].type.startsWith("image/")) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.style.display = 'none';
                }
            } else {
                fileName.textContent = 'No file chosen';
                removeButton.style.display = 'none';
                preview.style.display = 'none';
            }
        }

        function removeFile() {
            var input = document.getElementById('imageUpload');
            var preview = document.getElementById('imagePreview');
            input.value = "";
            preview.style.display = 'none';
            displayFileName();
        }

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

        // for data tables
        $.fn.dataTable.ext.errMode = 'none';
        $(document).ready(function() {
            $('.dataTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthMenu": [5, 10, 25, 50],
                "pagingType": "simple_numbers",
                "language": {
                    "search": "", // Removes "Search:" label
                    "lengthMenu": "Show _MENU_ entries",
                    "paginate": {
                        "next": "<i class='fas fa-chevron-right'></i>",
                        "previous": "<i class='fas fa-chevron-left'></i>"
                    }
                },
                "initComplete": function() {
                    $('.dataTables_filter input[type="search"]')
                        .attr('placeholder', 'Search here...')
                        .css({
                            'width': '200px'
                        }); // optional: styling
                }
            });
        });


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
    </script>




    @stop