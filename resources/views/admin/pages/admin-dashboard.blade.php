@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/admin-dash.css') }}">
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

    <div class="tab-bg p-4 mt-4">
        <!-- Customer List -->

        <h2 class="my-4">Customer List</h2>
        <div class="table-responsive">
            <table class="dataTable table table-bordered">
                <thead class="table-light">
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
                    @foreach($user_data as $user)
                    <tr>
                        <td>{{ $user['company_name'] ?? '' }}</td>
                        <td>{{ $user->user->name ?? '' }}</td>
                        <td>{{ $user->user->last_name ?? '' }}</td>
                        <td>{{ $user['city'] ?? '' }}</td>
                        <td>{{ $user['state'] ?? '' }}</td>
                        <td>{{ $user['zipcode'] ?? '' }}</td>
                        <td>{{ $user['billing_email'] ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('m/d/Y') ?? '' }}</td>
                        <td class="operation-icons">
                            <button class="btn btn-outline-primary btn-sm rounded-circle view-btn" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm rounded-circle edit-btn" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
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
                <thead class="table-light">
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

                    @if(!empty($blastInvoiceData) && count($blastInvoiceData) > 0)
                    @foreach($blastInvoiceData as $invoice)
                    <tr>
                        <td>{{ $invoice->blast_invoice_num  ?? 'N/A' }}</td>
                        <td>{{ $invoice->blast->blast_name ?? 'N/A' }}</td>
                        <td>{{ $invoice->field3 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field4 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field5 ?? 'N/A' }}</td>
                        <td>{{ $invoice->created_at ? \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $invoice->field7 ?? 'N/A' }}</td>
                        <td>{{ $invoice->blast->status ?? 'N/A' }}</td>
                        <td>{{ $invoice->field9 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field10 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field11 ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                    @else
                    <!-- Dummy row to prevent DataTables column mismatch -->
                    <tr class="d-none">
                        <td colspan="11"></td>
                    </tr>
                    <tr>
                        <td colspan="11" class="text-center">No Blasts Sent Yet.</td>
                    </tr>
                    @endif
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
</script>




@stop