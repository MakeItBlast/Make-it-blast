@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/create-discount.css') }}">

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


    <div class="tab-bg p-4">

        <!-- Coupon Table -->
        <h5 class="mb-3">Coupon</h5>
        <div class="table-responsive" style="max-height: 150px; overflow-y: auto;">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Coupon Code</th>
                        <th>Expire</th>
                        <th>Credits</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>WROSE101</td>
                        <td>1/24/25</td>
                        <td>10000</td>
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

        <!-- Coupon Information -->
        <h5 class="mb-3">Input Coupon Information</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Coupon Code</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Expiration Date</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Credit Cost</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-1 d-flex align-items-end">
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

        <hr class="my-4">

        <!-- Footer Message -->
        <h5 class="mb-3">Footer Message</h5>
        <div class="d-flex align-items-center">
            <input type="text" class="form-control me-2" placeholder="Enter footer message">
            <button class="btn btn-primary">SAVE</button>
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