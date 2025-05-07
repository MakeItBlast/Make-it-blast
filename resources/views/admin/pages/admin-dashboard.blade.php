@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/admin-dash.css') }}">

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

    <div class="tab-bg p-4 mt-4">
        <!-- Customer List -->

        <h2 class="my-4">Customer List</h2>
        <div class="table-responsive">
            <table  class=" dataTable table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Company</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zipcode</th>
                        <th>Email</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Group of People Network</td>
                        <td>Francesine</td>
                        <td>Williamson</td>
                        <td>Michigan</td>
                        <td>IN</td>
                        <td>450232</td>
                        <td>fwilliamson@</td>
                        <td>12/31/2024</td>
                        <td class="operation-icons">
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Marcus Liberty Crew</td>
                        <td>Glenn</td>
                        <td>Hampton</td>
                        <td>Killington</td>
                        <td>MS</td>
                        <td>650283</td>
                        <td>hamptong@y</td>
                        <td>11/04/2024</td>
                        <td class="operation-icons">
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="highlight">
                        <td>Justus Church in Christ</td>
                        <td>Janice</td>
                        <td>Drakington</td>
                        <td>Lexington</td>
                        <td>IL</td>
                        <td>894832</td>
                        <td>jdraking@ho</td>
                        <td>09/14/2024</td>
                        <td class="operation-icons">
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-bg p-4 mt-4">
        <!-- Blast List Section -->
        <h2 class="text-center mt-4">
            <strong>Customer Name:</strong> <span class="highlight">Justus Church in Christ</span>
        </h2>
        <div class="text-center">
            <span class="text-green">In Progress</span> |
            <span class="text-red">Need Payment</span> |
            <span>Completed</span>
        </div>

        <h4 class="mt-3">Blast List</h4>
        <div class="table-responsive">
            <table class="dataTable table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice #</th>
                        <th>Blast Name</th>
                        <th>Recipients</th>
                        <th>Blasts</th>
                        <th>Completed</th>
                        <th>Start Date</th>
                        <th>Credit Used</th>
                        <th>Success</th>
                        <th>Failure</th>
                        <th>Replies</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-green">
                        <td>10203023</td>
                        <td>Winter Rose Peeps</td>
                        <td>1,203</td>
                        <td>10</td>
                        <td>2</td>
                        <td>12/14/2024</td>
                        <td>1130</td>
                        <td>2,406</td>
                        <td>0</td>
                        <td>423</td>
                        <td class="actions">
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-edit"></i>
                        </td>
                    </tr>
                    <tr class="text-red">
                        <td>10203421</td>
                        <td>Micheal Birthday Party</td>
                        <td>31,080</td>
                        <td>5</td>
                        <td>0</td>
                        <td>12/24/2024</td>
                        <td>2400</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td class="actions">
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-edit"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p>Total Campaigns = 2</p>
        <p>Total Expense = $690.00</p>
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



<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.colVis.min.js"></script>

<script>
    // for error ans success message 
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

    // for table with export functionality 

    $(document).ready(function() {
        $('.dataTable').DataTable({
            dom: '<"top"Bf>rt<"bottom"ip>',
            buttons: [{
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> Export', // Label changed to "Export"
                className: 'btn btn-outline-success'
            }],
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [10, 25, 50, 100],
            pageLength: 10,
            language: {
                search: "Filter records:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    next: "<i class='fas fa-chevron-right'></i>", // Next icon
                    previous: "<i class='fas fa-chevron-left'></i>" // Previous icon
                }
            }
        });
    });

    
</script>




@stop