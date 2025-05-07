@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/blast-report.css') }}">

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

        <h5><strong>Report Filter</strong></h5>

        <div class="row">
            <div class="col-md-3">
                <label>Select Subscription</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Credits More Than</label>
                <input type="number" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Credits Less Than</label>
                <input type="number" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Start Date</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3 mt-2">
                <label>End Date</label>
                <input type="date" class="form-control">
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <label>Company Name</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <label>First Name</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Last Name</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label>City</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label>State</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <label>SMS / Email / Both</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Blast Start Time</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Blast End Time</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Time Zone</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <label>Integration</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Pictures</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Text Reply</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Failures</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <label>Search Text</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <hr>
        <h5><strong>Report Options</strong></h5>
        <div class="row">
            <div class="col-md-3">
                <label>Integration</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Produce Report</button>
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