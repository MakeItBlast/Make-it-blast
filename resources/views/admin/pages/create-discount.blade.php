@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/create-discount.css') }}">
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


    <div class="tab-bg p-4">

        <!-- Coupon Table -->
        <h3 class="mb-3">Create Coupon</h3>
        <div class="table-responsive">
            <table class="dataTable table table-bordered" style="width:100%;">
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
                    @forelse($getCoupons as $coupon)
                    <tr>
                        <td>{{ $coupon->cpn_code }}</td>
                        <td>{{ $coupon->cpn_exp_date }}</td>
                        <td>{{ number_format($coupon->credit_cost) }}</td>
                        <td>
                            <label class="switch" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Click to update the status of coupon">
                                <input type="checkbox" class="coupon-status-toggle"
                                    data-id="{{$coupon->id}}"
                                    {{ $coupon->status === 'active' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <div class="action-btns">
                                <form method="post" action="{{ url('update-coupon') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="updId" value="{{$coupon->id}}">
                                    <button type="submit" class="edit-ticket">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </form>

                                <form method="post" action="{{url('delete-coupon')}}">
                                    @csrf
                                    <input type="hidden" name="delId" value="{{$coupon->id}}">
                                    <button type="submit" class="dlt-ticket">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No coupons available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <!-- Coupon Information -->
        <h5 class="mb-3">Input Coupon Information</h5>
        <div class="row g-3">
            <form method="POST" action="{{ url('store-discount') }}">
                @csrf
                <input type="hidden" name="updId" value="{{ $getCouponStr->id ?? '' }}">

                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Coupon Code</label>
                        <input type="text" name="cpn_code" class="form-control"
                            value="{{ isset($getCouponStr) && $getCouponStr->cpn_code ? $getCouponStr->cpn_code : ($uniqueCode ?? '') }}">

                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Expiration Date</label>
                        <input type="datetime-local" name="cpn_exp_date" class="form-control"
                            value="{{ $getCouponStr->cpn_exp_date ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Credit Cost</label>
                        <input type="text" name="cpn_credit" class="form-control"
                            value="{{ $getCouponStr->credit_cost ?? '' }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" name="cpn_status" type="checkbox" id="active" value="active"
                                {{ (old('cpn_status', $getCouponStr->status ?? '') === 'active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end my-3">
                    <button type="submit" class="btn btn-primary me-2">
                        {{ isset($getCouponStr) ? 'Update' : 'Save' }}
                    </button>
                    <button type="reset" class="btn btn-outline-danger">Clear</button>
                </div>
            </form>

        </div>
    </div>

    <div class="tab-bg my-4">
        <h3 class="mb-3">Add Issue Type</h3>
        <form class="d-flex" method='post' action="{{url('store-issue-type')}}">
            @csrf
            <input type="hidden" name="updId" value="{{$getSelectedIssueData->id ?? ''}}">
            <input type="text" class="form-control me-2" name="issue_type" placeholder="Please enter new issue type" value="{{$getSelectedIssueData->issue_type ?? ''}}">
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="tab-bg my-4">
        <div class="table-container">
            <h3 class="mb-3">Issue Types</h3>
            <div class="table-responsive">

                <table class="dataTable table table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Issue Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $incr = 1; @endphp
                        @forelse($getIssueData as $issue)
                        <tr>
                            <td>{{ $incr++ }}</td>
                            <td>{{ $issue->issue_type }}</td>
                            <td>
                                <label class="switch" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Click to update the status of issue type">
                                    <input type="checkbox" class="issue-status-toggle"
                                        data-id="{{$issue->id}}"
                                        {{ $issue->status === 'active' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <form method="post" action="{{ url('create-discount') }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$issue->id}}">
                                        <button type="submit" class="edit-ticket">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </form>

                                    <form method="post" action="{{url('delete-issue-types')}}">
                                        @csrf
                                        <input type="hidden" name="delId" value="{{$issue->id}}">
                                        <button type="submit" class="dlt-ticket">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No coupons available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="tab-bg my-4">
        <!-- Footer Message -->
        <h3 class="mb-3">Footer Message</h3>

        <form method="post" action="{{url('add-footer-message')}}">
            @csrf
            <div class="d-flex align-items-center">
                <input type="text" name="footer_message" class="form-control me-2" placeholder="Enter footer message">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>

        <div class="my-4">
            <h3>Active Footer Message</h3>

            <p class="">{{ $footerMessage}}</p>
        </div>
    </div>

</div>


<!-- Popup Boxes -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('delete-contact/' . ($contact->id ?? '')) }}" id="deleteCardForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Issue type?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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


    // for data table 
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


    //for coupon status
    $(document).ready(function() {
        $('.coupon-status-toggle').on('change', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 'active' : 'inactive';

            $.ajax({
                url: "{{ url('update-status') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    console.log('ab', response);
                    console.log('abc', id);
                    if (response.status === 'success') {
                        alert("Status updated to " + status);
                    } else {
                        alert("Failed to update status");
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                    console.log(xhr.responseText);
                }
            });
        });
    });



    //for issue status
    $(document).ready(function() {
        $('.issue-status-toggle').on('change', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 'active' : 'inactive';

            $.ajax({
                url: "{{ url('update-status-types') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Status updated to " + status);
                    } else {
                        alert("Failed to update status");
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.status + " " + xhr.statusText);
                    console.log(xhr.responseText);
                }
            });
        });
    });

    // For tooltip 
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>


@stop