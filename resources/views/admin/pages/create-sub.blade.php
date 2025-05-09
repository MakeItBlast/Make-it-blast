@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/create-sub.css') }}">
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

        <!-- Subscriptions List -->
        <h3 class="mb-3">Subscriptions</h3>
        <div class="table-responsive">
            <table class="dataTable table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Subscription Name</th>
                        <th>KW</th>
                        <th>Duration</th>
                        <th>Credits</th>
                        <th>Monthly Cost</th>
                        <th>Discount</th>
                        <th>Yearly Cost</th>
                        <th>None-Sub</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getAllSubscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->subsc_name }}</td>
                        <td>{{ $subscription->keyword_allowed_count }}</td>
                        <td>{{ $subscription->duration }}</td>
                        <td>{{ $subscription->credit_cost }}</td>
                        <td>${{ number_format($subscription->monthly_cost, 2) }}</td>
                        <td>{{ $subscription->discount ?? 0 }}%</td>
                        <td>${{ number_format($subscription->yearly_cost, 2) }}</td>
                        <td>{{ $subscription->surcharge ?? 0 }}</td>
                        <td>
                            <label class="switch" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Click to update the status of subscription plan">
                                <input type="checkbox" class="subscription-status-toggle"
                                    data-id="{{ $subscription->id }}"
                                    {{ $subscription->status === 'active' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <div class="action-btns">
                                <form method="post" action="{{ url('edit-subscription') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="updId" value="{{ $subscription->id }}">
                                    <button type="submit" class="edit-ticket">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </form>

                                <form method="post" action="{{url('delete-subscription')}}">
                                    @csrf
                                    <input type="hidden" name="delId" value="{{$subscription->id}}">
                                    <button type="submit" class="dlt-ticket">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>


    </div>

    <div class="tab-bg p-4 my-4">
        <!-- Selected Subscription Section -->

        <h3 class="mb-3">Selected Subscription</h3>

        <form method="POST" action="{{ url('store-subscriptions') }}">
            @csrf

            <!-- Hidden ID field (only if updating an existing subscription) -->
            @if(isset($updateSubscription))
            <input type="hidden" name="updId" value="{{ $updateSubscription->id }}">
            @endif


            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Subscription Name</label>
                    <input type="text" name="subsc_name" class="form-control"
                        value="{{ old('subsc_name', $updateSubscription->subsc_name ?? '') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" name="status" type="checkbox" id="active" value="active"
                            {{ old('status', $updateSubscription->status ?? '') == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 my-3">
                <div class="col-md-2">
                    <label class="form-label">Key Words</label>
                    <input type="number" name="keyword_allowed_count" class="form-control"
                        value="{{ old('keyword_allowed_count', $updateSubscription->keyword_allowed_count ?? '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">SMS</label>
                    <input type="number" name="sms_allowed_count" class="form-control"
                    value="{{ old('sms_allowed_count', $updateSubscription->sms_allowed_count ?? '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">EMAIL</label>
                    <input type="number" name="email_allowed_count" class="form-control"
                    value="{{ old('email_allowed_count', $updateSubscription->email_allowed_count ?? '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Social Media</label>
                    <input type="number" name="social_allowed_count" class="form-control"
                    value="{{ old('social_allowed_count', $updateSubscription->social_allowed_count ?? '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">AI</label>
                    <input type="number" name="ai_allowed_count" class="form-control"
                    value="{{ old('ai_allowed_count', $updateSubscription->ai_allowed_count ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Picture</label>
                    <input type="number" name="image_allowed_count" class="form-control"
                    value="{{ old('image_allowed_count', $updateSubscription->image_allowed_count ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Text Reply</label>
                    <input type="number" name="replies_allowed_count" class="form-control"
                    value="{{ old('replies_allowed_count', $updateSubscription->replies_allowed_count ?? '') }}">
                </div>
            </div>

            <div class="row g-3 my-3">
                <!-- <div class="col-md-2">
                    <label class="form-label">Key Words</label>
                    <input type="number" name="keyword_allowed_count" class="form-control"
                        value="{{ old('keyword_allowed_count', $updateSubscription->keyword_allowed_count ?? '') }}">
                </div> -->
                <div class="col-md-2">
                    <label class="form-label">Duration (Days)</label>
                    <input type="number" name="duration" class="form-control"
                        value="{{ old('duration', $updateSubscription->duration ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Credit Cost</label>
                    <input type="number" name="credit_cost" class="form-control"
                        value="{{ old('credit_cost', $updateSubscription->credit_cost ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Monthly Cost($)</label>
                    <input type="number" step="0.01" name="monthly_cost" class="form-control" id="monthlyCost"
                        value="{{ old('monthly_cost', $updateSubscription->monthly_cost ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Discount(%)</label>
                    <input type="number" step="0.01" name="discount" class="form-control" id="discount"
                        value="{{ old('discount', $updateSubscription->discount ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Yearly Cost($)</label>
                    <input type="number" name="yearly_cost" class="form-control" id="yearlyCost" readonly
                        value="{{ old('yearly_cost', $updateSubscription->yearly_cost ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Surcharge</label>
                    <input type="number" name="surcharge" class="form-control"
                        value="{{ old('surcharge', $updateSubscription->surcharge ?? '') }}">
                </div>
            </div>

            <div class="d-flex justify-content-end my-3 gap-2">
                <button type="submit" class="btn btn-outline-primary">
                    {{ isset($updateSubscription->id) ? 'UPDATE' : 'SAVE' }}
                </button>
                <button type="reset" class="btn btn-outline-danger">CLEAR</button>
            </div>
        </form>
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
            "pagingType": "simple_numbers", // Only prev/next + numbers
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>", // Next icon
                    "previous": "<i class='fas fa-chevron-left'></i>" // Previous icon
                }
            }
        });
    });

    // for status of plans

    $(document).ready(function() {
        $('.subscription-status-toggle').on('change', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 'Active' : 'Inactive';

            $.ajax({
                url: "{{ url('update-subscription-status') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status
                },
                success: function(response) {
                    console.log('res',response);
                    if (response.status === 'success') {
                        //alert("Status updated to " + status);
                        
                        showToast("Status updated to " + status,'success');
                    } else {
                       // alert("Failed to update status");
                      
                    }
                },
                error: function() {
                    showToast(status,'error'); 
                }
            });
        });
    });

    // for calculating yearly cost

    function calculateYearlyCost() {
        let monthly = parseFloat($('#monthlyCost').val()) || 0;
        let discount = parseFloat($('#discount').val()) || 0;

        let yearly = monthly * 12 * (1 - discount / 100);
        $('#yearlyCost').val(yearly.toFixed(2));
    }

    $(document).ready(function() {
        $('#monthlyCost, #discount').on('input', calculateYearlyCost);
        calculateYearlyCost(); // initialize on load
    });

    // For tooltip 
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>



@stop