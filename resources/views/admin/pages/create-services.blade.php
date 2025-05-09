@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/create-services.css') }}">
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

        <!-- Service List -->
        <h5 class="mb-3">Service List</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                        <th>Credit Cost</th>
                        <th>Cost Per Blast</th>
                        <th>Dollar Value</th>
                        <th>Flat Rate</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getService as $service)
                    <tr>
                        <td>{{ $service['service_name'] }}</td>
                        <td>{{ $service['service_desc'] }}</td>
                        <td>{{ $service['cost_per_blast'] * env('DOLLAR_VALUE')  }}</td>
                        <td>${{ number_format($service['cost_per_blast'], 2) }}</td>
                        <td>${{ env('DOLLAR_VALUE') }}</td> {{-- Assuming Dollar Value = Cost Per Blast --}}
                        <td>{{ $service['flat_rate']}}</td>
                        <td class="{{ strtolower($service['status']) == 'active' ? 'text-success' : 'text-danger' }}">
                            {{ ucfirst($service['status']) }}
                        </td>
                        <td>
                            <form method="post" action="{{url('create-services')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$service->id}}">
                                <input type="submit" name="edit" value="edit">
                            </form>
                            <form method="post" action="{{url('delete-service')}}">
                                @csrf
                                <input type="hidden" name="delId" value="{{$service->id}}">
                                <input type="submit" name="delete" value="delete">
                            </form>
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

        <!-- Selected Service Section -->
        <form method="post" action="{{url('store-service')}}">
            @csrf
            <input type="hidden" name="id" value="{{ $service->id ?? '' }}">
            <h5 class="mb-3">Selected Service</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Service Name</label>
                    <input type="text" class="form-control" name="service_name" value="{{old('service_name') ?? $updServiceData->service_name ?? ''}}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control" name="service_desc" value="{{old('service_desc')??$updServiceData->service_desc ?? ''}}">
                </div>
            </div>

            <div class="row g-3 my-3">
                <div class="col-md-3 d-flex flex-column">
                    <label class="form-label">Credit Cost</label>
                    <span id="credit_cost_autofill">{{ $updServiceData->credit_cost_autofill ?? '' }}</span>
                </div>
                <div class="col-md-3 d-flex flex-column">
                    <label class="form-label">Cost Per Blast</label>
                    <span id="cost_per_blast_autofill">{{ $updServiceData->cost_per_blast ?? '' }}</span>
                </div>
                <div class="col-md-3 d-flex flex-column">
                    <label class="form-label">Dollar Value</label>
                    <span id="dollar_value_autofill">{{ env('DOLLAR_VALUE') }}</span>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" id="flatRate" name="flat_rate" value="1" {{ isset($updServiceData) && $updServiceData->flat_rate == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flatRate">Flat Rate</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="active" name="status" value="1" {{ isset($updServiceData) && $updServiceData->status == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('cost_per_blast_input');
                    const span = document.getElementById('cost_per_blast_autofill');

                    input.addEventListener('input', function() {
                        span.textContent = input.value;
                    });
                });
            </script>

            @php
            $dollarValue = env('DOLLAR_VALUE', 1); // Fallback to 1 if not set
            @endphp

            <hr class="my-4">
            <h5 class="mb-3">Set System Values</h5>
            <div class="row g-3">

                <div class="col-md-5">
                    <label class="form-label">Yearly Discount</label>
                    <input type="number" class="form-control" name="yearly_discount" value="{{old('yearly_discount')??$updServiceData->yearly_discount ?? ''}}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Cost Per Blast</label>
                    <input type="number" class="form-control" name="cost_per_blast" id="cost_per_blast_input" value="{{ old('cost_per_blast') ?? $updServiceData->cost_per_blast ?? '' }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">SAVE</button>
                    <button type="reset" class="btn btn-primary w-100">RESET</button>
                </div>
        </form>
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
    document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('cost_per_blast_input');
    const span = document.getElementById('credit_cost_autofill');

    // Ensure the PHP variable is correctly injected into the JavaScript
    const dollarValue = {{ $dollarValue }};  // Remove quotes if it's a number

    function updateSpan() {
        const inputValue = parseFloat(input.value) || 0;
        const totalCost = inputValue * dollarValue;
        span.textContent = totalCost.toFixed(2); // Format to 2 decimal places
    }

    // Initial update
    updateSpan();

    // Listen to input changes
    input.addEventListener('input', updateSpan);
});

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