@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/service-payments.css') }}">

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

        <!-- Service Payments -->
        <h4>Invoice List</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice #</th>
                        <th>Invoice Date</th>
                        <th>User / Customer</th>
                        <th>Credit Card</th>
                        <th>Transaction Date</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10203023</td>
                        <td>12/14/2024</td>
                        <td>Justus Church in Christ</td>
                        <td>XXXX-XXXX-XXXX-3845</td>
                        <td>12/15/2024 : 09:34 AM CST</td>
                        <td>$49.99</td>
                    </tr>
                    <tr>
                        <td>10203023</td>
                        <td>12/24/2024</td>
                        <td>Justus Church in Christ</td>
                        <td>XXXX-XXXX-XXXX-3845</td>
                        <td>12/15/2024 : 09:34 AM CST</td>
                        <td>$100.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p><strong>Totals:</strong> $149.99</p>

        <hr>
        <h4>Selected Invoice</h4>
        <div class="border p-3">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Company Name:</strong> Justus Church in Christ</p>
                    <p><strong>City:</strong> Oswego &nbsp; <strong>State:</strong> Illinois &nbsp;
                        <strong>Zipcode:</strong> 60534
                    </p>
                    <p><strong>Billing Email:</strong> abcwindy@gmail.com</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Invoice Date:</strong> 12/15/24</p>
                    <p><strong>Invoice #:</strong> 10203023</p>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Service Name</th>
                            <th>Term</th>
                            <th>Duration</th>
                            <th>Credits</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Plan</td>
                            <td>Monthly</td>
                            <td>30</td>
                            <td>1000</td>
                            <td>$39.99</td>
                        </tr>
                        <tr>
                            <td>Added Credits</td>
                            <td>-</td>
                            <td>-</td>
                            <td>200</td>
                            <td>$10.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>Totals:</strong> 1200 Credits &nbsp; | &nbsp; <strong>$49.99</strong></p>

            <div class="d-flex justify-content-center gap-3 mt-3">
                <button class="btn btn-outline-secondary">Edit Customer</button>
                <button class="btn btn-outline-secondary">Print</button>
                <button class="btn btn-outline-secondary">Re-Send Invoice</button>
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