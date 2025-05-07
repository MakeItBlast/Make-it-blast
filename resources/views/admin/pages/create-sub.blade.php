@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/create-sub.css') }}">

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

        <!-- Subscriptions List -->
        <h5 class="mb-3">Subscriptions</h5>
        <div class="table-responsive" style="max-height: 150px; overflow-y: auto;">
        <table class="table table-bordered text-center">
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
                        <td class="{{ $subscription->status === 'Active' ? 'text-success' : 'text-danger' }}">
                            {{ $subscription->status }}
                        </td>
                        <td>
                            <a href="{{url('delete-subscription/'.$subscription->id)}}">delete</a>
                            <a href="{{url('edit-subscription/'.$subscription->id)}}">edit</a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        </div>

        <!-- Search Section -->
        <div class="d-flex align-items-center my-3">
            <input type="text" class="form-control me-2" placeholder="Search..." style="max-width: 200px;">
            <button class="btn btn-outline-primary">Go</button>
        </div>

        <!-- Selected Subscription Section -->
        <form method="POST" action="{{ url('store-subscriptions') }}">
    @csrf

    <!-- Hidden ID field (only if updating an existing subscription) -->
    @if(isset($updateSubscription))
        <input type="hidden" name="id" value="{{ $updateSubscription->id }}">
    @endif

    <h5 class="mb-3">Selected Subscription</h5>
    <div class="row g-3">
        <div class="col-md-8">
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
            <input type="text" name="keyword_allowed_count" class="form-control"
                value="{{ old('keyword_allowed_count', $updateSubscription->keyword_allowed_count ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Duration (Days)</label>
            <input type="text" name="duration" class="form-control"
                value="{{ old('duration', $updateSubscription->duration ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Credit Cost</label>
            <input type="text" name="credit_cost" class="form-control"
                value="{{ old('credit_cost', $updateSubscription->credit_cost ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Monthly Cost</label>
            <input type="text" name="monthly_cost" class="form-control"
                value="{{ old('monthly_cost', $updateSubscription->monthly_cost ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Discount</label>
            <input type="text" name="discount" class="form-control"
                value="{{ old('discount', $updateSubscription->discount ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Yearly Cost</label>
            <input type="text" name="yearly_cost" class="form-control"
                value="{{ old('yearly_cost', $updateSubscription->yearly_cost ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Surcharge</label>
            <input type="text" name="surcharge" class="form-control"
                value="{{ old('surcharge', $updateSubscription->surcharge ?? '') }}">
        </div>
    </div>

    <div class="d-flex justify-content-end my-3">
        <button type="submit" class="btn btn-primary me-2">SAVE</button>
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