@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/contact-type.css') }}">

@section('content')
<!-- Display any errors if present -->


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

    <!-- Contact Type Tab -->

    <div class="tab-bg my-4">
        <h2 class="fw-bold">Contact Type List</h2>
        <div class="table-responsive my-4">
            <table class="dataTable table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Type ID</th>
                        <th>Contact Type</th>
                        <th>Type Description</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $incr = 1; @endphp
                    @forelse($contactTypes as $contactType)
                    <tr>
                        <td>{{ $incr }}</td>
                        <td>{{ $contactType->contact_type }}</td>
                        <td>{{ $contactType->contact_desc }}</td>
                        <td>{{ $contactType->status == 'active' ? 'Active' : 'Inactive' }}</td>
                        <td class="operation-icons">
                            <a href="{{ url('update-contact-type/'.$contactType->id) }}"><i class="fa-solid fa-pencil"></i></a>

                            <a href="#" class="delete-card-btn" data-url="{{ url('delete-contact-type/'.$contactType->id) }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                    @php $incr++; @endphp
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No contact types available.</td>
                    </tr>
                    @endforelse


                </tbody>
            </table>

        </div>

        <p class="text-end"><strong>Total = {{count($contactTypes)}}</strong></p>
    </div>

    <div class="tab-bg m-y4">
        <!-- Add Contact Type Form -->
        <h2 class="fw-bold">Add Contact Type</h2>

        <form method="POST" action="{{url('store-contact-type')}}">

            @csrf
            <div class="mb-3">
                <label class="form-label">Contact Type</label>
                <input type="text" name="contact_type" class="form-control" value="{{$updateContactType->contact_type ?? ''}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="contact_desc">{{$updateContactType->contact_desc ?? ''}}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Enabled</label>
                <input type="checkbox" name="status" value="active" {{ isset($updateContactType) && $updateContactType->status == 'active' ? 'checked' : '' }}>

            </div>

            <input type="hidden" name="update_id" value="{{$updateContactType->id ?? ''}}">
            <button type="submit" class="btn btn-success">
                {{ $updateContactType ?? false ? 'UPDATE' : 'SAVE' }}
            </button>
            <button type="reset" class="btn btn-secondary">CLEAR</button>

        </form>
    </div>



</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="" id="deleteCardForm">
                @csrf
                @method('DELETE') <!-- This tells Laravel to treat it as a DELETE request -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this credit card?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
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

    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-card-btn");
        const deleteForm = document.getElementById("deleteCardForm");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                const deleteUrl = this.getAttribute("data-url");
                deleteForm.setAttribute("action", deleteUrl);
            });
        });
    });


    // for error and success popup

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