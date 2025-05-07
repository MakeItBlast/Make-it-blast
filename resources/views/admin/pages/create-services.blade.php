@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/create-services.css') }}">

@section('content')
@if ($errors->any())
<div class="overlay" id="errorOverlay" data-close="true">   <!-- Overlay with data attribute -->
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
<div class="overlay" id="successOverlay" data-close="true">   <!-- Overlay with data attribute -->
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


    <div class="tab-bg p-4">

        <!-- Service List -->
        <h5 class="mb-3">Service List</h5>
        <div class="table-responsive" style="max-height: 150px; overflow-y: auto;">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                        <th>Credit Cost</th>
                        <th>Cost Per Blast</th>
                        <th>Dollar Value</th>
                        <th>Flat Rate</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SMS</td>
                        <td>Sending Text Messages</td>
                        <td>1</td>
                        <td>$0.05</td>
                        <td>$0.05</td>
                        <td>No</td>
                        <td class="text-success">Active</td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Picture Placement</td>
                        <td>Sending Text Messages</td>
                        <td>10</td>
                        <td>$0.05</td>
                        <td>$0.50</td>
                        <td>Yes</td>
                        <td class="text-success">Active</td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Search Section -->
        <div class="d-flex align-items-center my-3">
            <input type="text" class="form-control me-2" placeholder="Search..." style="max-width: 200px;">
            <button class="btn btn-outline-primary">Go</button>
        </div>

        <!-- Selected Service Section -->
        <h5 class="mb-3">Selected Service</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Service Name</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Description</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row g-3 my-3">
            <div class="col-md-3">
                <label class="form-label">Credit Cost</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Cost Per Blast</label>
                <p class="form-control-plaintext">$0.05</p>
            </div>
            <div class="col-md-3">
                <label class="form-label">Dollar Value</label>
                <p class="form-control-plaintext">$0.75</p>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="flatRate">
                    <label class="form-check-label" for="flatRate">Flat Rate</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="active">
                    <label class="form-check-label" for="active">Active</label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end my-3">
            <button class="btn btn-primary me-2">SAVE</button>
            <button class="btn btn-outline-danger">CLEAR</button>
        </div>

        <!-- Set System Values Section -->
        <hr>
        <h5 class="mb-3">Set System Values</h5>
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Yearly Discount</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-5">
                <label class="form-label">Cost Per Blast</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">SAVE</button>
            </div>
        </div>

    </div>


</div>


<!-- Popup Boxes -->
     
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Credit Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this credit card?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

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
    </script>


@stop