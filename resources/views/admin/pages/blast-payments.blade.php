@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/blast-payment.css') }}">

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

        <!-- Blast Payments -->
        <h4><strong>Blast Name:</strong> Winter Rose Peeps</h4>
        <h5>Blast Payment List</h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice #</th>
                        <th>Invoice Date</th>
                        <th>Blast Name</th>
                        <th>Recipients</th>
                        <th>Blast Count</th>
                        <th>Credit Used</th>
                        <th>Status</th>
                        <th>Completed Date</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10203023</td>
                        <td>12/14/2024</td>
                        <td>Winter Rose Peeps Active</td>
                        <td>4300</td>
                        <td>2</td>
                        <td>1150</td>
                        <td>Not Paid</td>
                        <td>12/17/24</td>
                        <td><button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr>
        <h5>Company & Invoice Details</h5>
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
        </div>

        <hr>
        <h5>Blast Summary</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Blast Name</th>
                        <th>Recipients</th>
                        <th>Blasts</th>
                        <th>Completed</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Credit Used</th>
                        <th>Success</th>
                        <th>Failure</th>
                        <th>Replies</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Winter Rose Peeps</td>
                        <td>4,300</td>
                        <td>2</td>
                        <td>2</td>
                        <td>12/14/2024</td>
                        <td>12/14/2024</td>
                        <td>1150</td>
                        <td>784</td>
                        <td>16</td>
                        <td>521</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr>
        <h5>Service Breakdown</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Service Description</th>
                        <th>Credit Cost</th>
                        <th>Quantity</th>
                        <th>Total Credits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SMS Contact Count</td>
                        <td>405</td>
                        <td>2</td>
                        <td>810</td>
                    </tr>
                    <tr>
                        <td>Image Cost</td>
                        <td>20</td>
                        <td>2</td>
                        <td>40</td>
                    </tr>
                    <tr>
                        <td>Blast Cost</td>
                        <td>2</td>
                        <td>2</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>AI Integration</td>
                        <td>100</td>
                        <td>1</td>
                        <td>100</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p><strong>Total Credits:</strong> 1150</p>

        <hr>
        <h5>Schedule Details</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Schedule Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1/24/2025</td>
                        <td>10:00 PM CST</td>
                    </tr>
                    <tr>
                        <td>2/24/2025</td>
                        <td>09:00 PM CST</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p><strong>Total Schedules:</strong> 2</p>

        <div class="d-flex justify-content-center gap-3 mt-3">
            <button class="btn btn-outline-secondary">Re-Send Invoice</button>
            <button class="btn btn-outline-secondary">Redo Blast</button>
            <button class="btn btn-outline-secondary">Print</button>
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