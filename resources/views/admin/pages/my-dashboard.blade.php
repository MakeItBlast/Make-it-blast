@extends('admin.layout.app')

<link rel="stylesheet" href="{{ asset('styles/my-dash.css') }}">


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

    <div class="tab-bg mt-4 mb-4">
        <!-- My Active Subscriptions -->
        <h3>My Active Subscriptions</h3>

        <div class="table-responsive">
            <table class="dataTable table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Subscription Name</th>
                        <th>Credit Card Number</th>
                        <th>Expiration Date</th>
                        <th>Last Processed</th>
                        <th>Days Remaining</th>
                        <th>Account Status</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gold</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>
                    <tr>
                        <td>Premium</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>
                    <tr>
                        <td>Platinum</td>
                        <td>12233222525</td>
                        <td>1/23/2052</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>inactive</td>
                        <td>5600</td>
                    </tr>
                    <tr>
                        <td>Premium</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>
                    <tr>
                        <td>Premium</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>

                    <tr>
                        <td>Premium</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>

                    <tr>
                        <td>Premium</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>

                    <tr>
                        <td>Premium</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>1/23/2026</td>
                        <td>12/23/2025</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td>500</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-bg mt-4 mb-4">
        <!-- Coupon Form -->
        <form class="mb-0">
            @csrf
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-primary">Apply Coupon</button>
                    <input type="text" class="form-control d-inline-block w-auto" placeholder="Enter Coupon">
                </div>
                <div>
                    <a href="#" class="btn btn-outline-success">
                        Buy More Credits
                    </a>
                    <span class="ms-2">Total Available Credits: <strong>456</strong></span>
                </div>
            </div>

        </form>
    </div>



    <div class="tab-bg">
        <!-- My Blasts Section -->
        <h3>My Blasts</h3>
        <p>
            <span class="text-success">In Progress</span> |
            <span class="text-danger">Need Payment</span> |
            <span class="text-secondary">Completed</span>
            <button class="btn btn-success float-end">Show All</button>
        </p>

        <!-- Blast Table -->
        <div class="table-responsive">
    <table id="blastTable" class="dataTable table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>Blast Name</th>
                <th>Recipients</th>
                <th>Blasts</th>
                <th>Completed</th>
                <th>Start Date</th>
                <th>End State</th>
                <th>Cost</th>
                <th>Success</th>
                <th>Failed</th>
                <th>Replies</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-success">Winter Rose Peeps</td>
                <td class="text-success">1,203</td>
                <td>10</td>
                <td>2</td>
                <td>12/14/2024</td>
                <td>12/24/2024</td>
                <td class="text-success">$255.00</td>
                <td class="text-success">2,406</td>
                <td>0</td>
                <td>423</td>
                <td>
                    <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td class="text-danger">Micheal Birthday Party</td>
                <td class="text-danger">31,080</td>
                <td>5</td>
                <td>0</td>
                <td>12/24/2024</td>
                <td>12/24/2024</td>
                <td class="text-danger">$435.00</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>
                    <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>B Cole Comedy Show</td>
                <td>400</td>
                <td>2</td>
                <td>2</td>
                <td>11/14/2024</td>
                <td>11/24/2024</td>
                <td>$255.00</td>
                <td>784</td>
                <td>16</td>
                <td>521</td>
                <td>
                    <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

    </div>
</div>



<!-- modal boxes -->

<!-- edit modal  -->

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
        "pagingType": "simple_numbers",  // Only prev/next + numbers
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "paginate": {
                "next": "<i class='fas fa-chevron-right'></i>",     // Next icon
                "previous": "<i class='fas fa-chevron-left'></i>"   // Previous icon
            }
        }
    });
});
</script>


@stop