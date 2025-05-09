@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/my-dash.css') }}">
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

    <div class="tab-bg my-4">
        <!-- My Active Subscriptions -->
        <h3>My Active Subscriptions</h3>

        <div class="table-responsive">
            <table  class="dataTable table table-bordered" style="width:100%;">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>Subscription Name</th>
                        <th>Start Date</th>
                        <th>Expiration Date</th>
                        <th>Last Processed</th>
                        <th>Days Remaining</th>
                        <th>Account Status</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody>
                    @php $incr = 1; @endphp
                    @if ($subscriptionData->count())
                    @foreach ($subscriptionData as $subscription)
                    @php
                    $startDate = \Carbon\Carbon::parse($subscription->created_at);
                    $expirationDate = $startDate->copy()->addDays($subscription->subscription->duration);
                    $remainingDays = now()->diffInDays($expirationDate, false);
                    @endphp
                    <tr> 
                        <td>{{ $incr++ }}</td>
                        <td>{{ $subscription->subscription->subsc_name }}</td>
                        <td>{{ $startDate->format('d-m-Y') }}</td>
                        <td>{{ $expirationDate->format('d-m-Y') }}</td>
                        <td>N/A</td>
                        <td>{{ $remainingDays >= 0 ? $remainingDays : 'Expired' }}</td>
                        <td>{{ $subscription->status }}</td>
                        <td>{{ $subscription->subscription->credit_cost }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">No Active Subscriptons available. Please purchase</td>
                    </tr>
                    @endif
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
                    <a href="{{ url('subscription') }}" class="btn btn-outline-success">
                        Buy More Credits
                    </a>
                    <span class="ms-2">Total Available Credits: <strong>456</strong></span>
                </div>
            </div>

        </form>
    </div>



    <div class="tab-bg my-4">
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
            <table class="dataTable table table-bordered" style="width:100%;">
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
                    @if(!empty($userBlastData) && count($userBlastData) > 0)
                    @foreach($userBlastData as $invoice)
                    <tr>
                        <td>{{ $invoice->blast_name ?? 'N/A' }}</td>
                        <td>{{ $invoice->field2 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field3 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field4 ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') ?? 'N/A' }}</td>
                        <td>{{ $invoice->field6 ?? 'N/A' }}</td>
                        <td>{{ $invoice->field7 ?? 'N/A' }}</td>
                        <td>{{ $invoice->status ?? 'N/A' }}</td>
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
                        <td colspan="8" class="text-center">No Active Subscriptions available. Please purchase</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>

    </div>
  
    @if(count($availableAnswere)>=1)
    <div class="tab-bg my-4">
        <a href="{{ url('download-replies') }}" class="btn btn-outline-primary"> 
        <i class="fa-solid fa-file-csv"></i><span>Download Replies</span>
        </a>
    </div>
    @endif
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