@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/manage-sub.css') }}">
@stop


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

        <!-- Subscription List -->
        <h5 class="mb-3">Subscription List</h5>
        <div class="table-responsive" style="max-height: 150px; overflow-y: auto;">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Credit Card Number</th>
                        <th>Subscription</th>
                        <th>Expiration Date</th>
                        <th>Last Processed</th>
                        <th>Account Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mark Williams</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>Gold</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
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

        <!-- Selected Subscription Section -->
        <h5 class="mb-3">Selected Subscription</h5>
        <div class="row">
            <div class="col-md-4">
                <strong>Company Name</strong>
                <p>Williams Corp</p>
            </div>
            <div class="col-md-4">
                <strong>First Name</strong>
                <p>Mark</p>
            </div>
            <div class="col-md-4">
                <strong>Last Name</strong>
                <p>Williams</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <strong>Subscription</strong>
                <p>Premium Service</p>
            </div>
            <div class="col-md-4">
                <strong>Term</strong>
                <p>Monthly</p>
            </div>
            <div class="col-md-4">
                <strong>Cost</strong>
                <p>$69.99</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <strong>Credits</strong>
                <p>1000</p>
            </div>
            <div class="col-md-4">
                <strong>Expiration Date</strong>
                <p>1/23/2026</p>
            </div>
            <div class="col-md-4">
                <strong>Last Processed</strong>
                <p>12/23/2025</p>
            </div>
        </div>

        <!-- Credit Card Form -->
        <div class="border p-3 my-3">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Credit Card</label>
                    <input type="text" class="form-control" placeholder="XXXX-XXXX-XXXX-2453">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Expiration Date</label>
                    <input type="text" class="form-control" placeholder="MM/YY">
                </div>
                <div class="col-md-2">
                    <label class="form-label">CVV</label>
                    <input type="text" class="form-control" placeholder="123">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Account Status</label>
                    <select class="form-select">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between my-3">
            <button class="btn btn-outline-secondary">Payment History</button>
            <div>
                <button class="btn btn-primary me-2">PROCESS</button>
                <button class="btn btn-outline-danger">CLEAR</button>
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