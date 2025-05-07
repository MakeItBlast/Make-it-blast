@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/subscription.css') }}">
@section('content')

@if ($errors->any())
<div class="error-messages">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="overlay" id="success-overlay">
    <div class="alert alert-success-message">
        <button class="close-btn" onclick="document.getElementById('success-overlay').style.display='none'"><i class="fa-solid fa-xmark"></i></button>
        <div class="icon-container">
            <img src="{{ asset('/media/login-success.gif') }}" class="d-block w-100">
        </div>
        <div class="message-content">
            <strong>Welcome back,</strong>
            <p>{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if (auth()->guest())
@php
header('Location: /make-it-blast');
exit();
@endphp
@endif

<div class="container my-4 py-4">
    <!-- Active Subscription Table -->
    <div class="container">
        <div class="card p-4">
            <h2 class="mb-4">Subscription Plans</h2>
            <div class="table-responsive">
                <table id="subscriptionTable" class="dataTable table table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Subscription Name</th>
                            <th>Credit Card Number</th>
                            <th>Start Date</th>
                            <th>Expiration Date</th>
                            <th>Term</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Credits</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Premium</td>
                            <td>XXXX-XXXX-XXXX-2453</td>
                            <td>1/23/2026</td>
                            <td>12/23/2025</td>
                            <td>Monthly</td>
                            <td>$69.99</td>
                            <td>Active</td>
                            <td>500</td>
                            <td><button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-xmark"></i>
                                </button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Subscription/Credit Purchase  -->
    <div class="container">
        <div class="form-section p-4">
            <h2 class="mb-4">Purchase Credits</h2>
            <div class="row mb-3">
                <!-- Subscription Section -->
                <div class="col-md-6 sub">
                    <h5 class="mt-2 mb-2">Buy Subscription</h5>
                    <form id="subscriptionForm">
                        <select name="subscription_id" class="form-select mt-2 mb-2" id="subscriptionSelect">
                            <option value="">Select Subscription</option>
                            @foreach($subscriptions as $subscription)
                            <option value="{{ $subscription->id }}"
                                data-name="{{ $subscription->subsc_name }}"
                                data-credits="{{ $subscription->credit_cost }}"
                                data-discount="{{ $subscription->discount }}"
                                data-monthly="{{ $subscription->monthly_cost }}"
                                data-duration="{{ $subscription->duration }}"
                                data-yearly="{{ $subscription->yearly_cost }}">
                                {{ $subscription->subsc_name }} - ${{ $subscription->monthly_cost }}
                            </option>
                            @endforeach
                        </select>
                        <button type="button" id="addSubscription" class="btn btn-outline-primary mt-2">Add To List</button>
                    </form>
                </div>

                <!-- Credits Section -->
                <div class="col-md-6 sub">
                    <h5 class="mt-2 mb-2">Buy Credits</h5>
                    <input type="number" id="creditAmount" class="form-control mt-2 mb-2" placeholder="Enter Credits" min="1">
                    <div class="input-group mb-2">
                        <span class="input-group-text">$0.05 per credit</span>
                        <input type="text" class="form-control" id="creditCostPreview" placeholder="Total Cost" readonly>
                    </div>
                    <button type="button" id="addCredits" class="btn btn-outline-primary mt-2">Add To List</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table to Show Data -->
    <div class="container py-4 my-4">

        <div class="tab-bg">
            <div class="table-responsive">
                <table id="serviceTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Duration</th>
                            <th>Credits</th>
                            <th>Cost</th>
                            <th>Discount</th>
                            <th>Payment Type</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Dynamic Rows Will be Added Here -->
                    </tbody>
                    <!-- Totals Row -->
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th id="totalCredits">0</th>
                            <th id="totalCost">$0.00</th>
                            <th id="totalDiscount">$0.00</th>
                            <th id="selectedPaymentType">-</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <!-- Payment Information Section -->
    <div class="container">
        <div class="form-section p-4">
            <h4 class="mt-2 mb-2">Payment Information</h4>
            <form method="POST" action="{{ route('payment.process') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="total_amount" id="total_amount" value="0">
                <input type="hidden" name="payment_type" id="payment_type" value="">
                <input type="hidden" name="items" id="order_items" value="">
                <input type="hidden" name="subscription_id" id="subscription_id_input" value="">
                <input type="hidden" name="credits" id="total_credits_input" value="0">

                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="f_name" value="{{old('f_name')}}" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="l_name" value="{{old('l_name')}}" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="row g-3 my-2">
                    <!-- Country -->
                    <div class="col-md-4">
                        <select id="country" name="country" class="form-select" onchange="loadStates()" required>
                            <option value="">Select Country</option>
                        </select>
                    </div>

                    <!-- State -->
                    <div class="col-md-4">
                        <select id="state" class="form-select" name="state" onchange="loadCities()" required>
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <!-- City -->
                    <div class="col-md-4">
                        <select id="city" class="form-select" name="city" required>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>

                <!-- Stripe Card Element -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="card-element" class="form-control p-2" style="height: 40px;"></div>
                        <div id="card-errors" role="alert" class="text-danger"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success" id="processPaymentBtn">Process Payment ($<span id="finalAmount">0.00</span>)</button>
                    </div>
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
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Data table Script -->
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
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


    // [Keep all your existing JavaScript code for table management]
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize variables
        let totalCredits = 0;
        let totalCost = 0;
        let totalDiscount = 0;
        let addedSubscriptions = new Set();
        let rowToDelete = null;
        const creditRate = 0.05; // $0.05 per credit
        let selectedPaymentType = 'monthly'; // Default payment type

        // Credit amount input live calculation
        document.getElementById('creditAmount').addEventListener('input', function() {
            const credits = parseInt(this.value) || 0;
            const cost = credits * creditRate;
            document.getElementById('creditCostPreview').value = `$${cost.toFixed(2)}`;
        });

        // Add Subscription to Table
        document.getElementById("addSubscription").addEventListener("click", function() {
            const select = document.getElementById("subscriptionSelect");
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value) {
                const subscriptionId = selectedOption.value;
                const paymentType = 'm'; // Default to monthly

                // Create unique identifier with subscription ID and payment type
                const subscriptionIdentifier = `${subscriptionId}-${paymentType}`;

                // Check if subscription already added
                if (addedSubscriptions.has(subscriptionIdentifier)) {
                    alert("This subscription with the same payment type is already added!");
                    return;
                }

                addedSubscriptions.add(subscriptionIdentifier);

                const subscName = selectedOption.getAttribute("data-name");
                const credits = parseInt(selectedOption.getAttribute("data-credits")) || 0;
                const monthlyCost = parseFloat(selectedOption.getAttribute("data-monthly")) || 0;
                const yearlyCost = parseFloat(selectedOption.getAttribute("data-yearly")) || 0;
                const discount = parseFloat(selectedOption.getAttribute("data-discount")) || 0;
                const duration = selectedOption.getAttribute("data-duration") || '30 days';

                const row = `
                    <tr data-subscription-id="${subscriptionId}" 
                        data-payment-type="${paymentType}"
                        data-credits="${credits}" 
                        data-monthly="${monthlyCost}" 
                        data-yearly="${yearlyCost}" 
                        data-discount="${discount}">
                        <td>${subscName}</td>
                        <td>${duration}</td>
                        <td>${credits}</td>
                        <td class="price-display">$${monthlyCost.toFixed(2)}</td>
                        <td class="text-danger">- $${Math.abs(discount).toFixed(2)}</td>
                        <td>
                            <select class="form-select payment-type" onchange="updatePaymentType(this)">
                                <option value="m" selected>Monthly (M)</option>
                                <option value="y">Yearly (Y)</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-outline-danger btn-sm rounded-circle delete-item" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                `;
                document.getElementById("tableBody").insertAdjacentHTML("beforeend", row);

                // Update totals with monthly cost by default
                totalCredits += credits;
                totalCost += monthlyCost;
                totalDiscount += discount;
                updateTotals();
            } else {
                alert("Please select a subscription!");
            }
        });

        // Add Credits to Table
        document.getElementById("addCredits").addEventListener("click", function() {
            const creditInput = document.getElementById("creditAmount");
            const creditAmount = parseInt(creditInput.value);

            if (creditAmount && creditAmount > 0) {
                const price = creditAmount * creditRate;

                const row = `
                    <tr data-credits="${creditAmount}" data-cost="${price}">
                        <td>Added Credits</td>
                        <td>-</td>
                        <td>${creditAmount}</td>
                        <td>$${price.toFixed(2)}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <button class="btn btn-outline-danger btn-sm rounded-circle delete-item" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                `;
                document.getElementById("tableBody").insertAdjacentHTML("beforeend", row);

                // Update totals
                totalCredits += creditAmount;
                totalCost += price;
                updateTotals();

                // Reset input
                creditInput.value = '';
                document.getElementById('creditCostPreview').value = '';
            } else {
                alert("Please enter a valid credit amount!");
            }
        });

        // Update payment type and recalculate totals
        function updatePaymentType(selectElement) {
            const row = selectElement.closest('tr');
            const paymentType = selectElement.value;
            selectedPaymentType = paymentType;

            if (row.hasAttribute('data-subscription-id')) {
                const subscriptionId = row.getAttribute('data-subscription-id');
                const oldPaymentType = row.getAttribute('data-payment-type');

                // Update the unique identifier in the Set
                const oldIdentifier = `${subscriptionId}-${oldPaymentType}`;
                const newIdentifier = `${subscriptionId}-${paymentType}`;

                if (addedSubscriptions.has(newIdentifier)) {
                    alert("This subscription with the selected payment type is already added!");
                    selectElement.value = oldPaymentType; // Revert the selection
                    return;
                }

                addedSubscriptions.delete(oldIdentifier);
                addedSubscriptions.add(newIdentifier);

                // Update the data attribute
                row.setAttribute('data-payment-type', paymentType);

                const monthlyCost = parseFloat(row.getAttribute('data-monthly')) || 0;
                const yearlyCost = parseFloat(row.getAttribute('data-yearly')) || 0;

                // Update the displayed price
                const priceDisplay = row.querySelector('.price-display');
                if (priceDisplay) {
                    priceDisplay.textContent = paymentType === 'm' ?
                        `$${monthlyCost.toFixed(2)}` :
                        `$${yearlyCost.toFixed(2)}`;
                }
            }

            // Recalculate totals based on new payment type
            recalculateTotals();
        }

        // Recalculate all totals based on selected payment types
        function recalculateTotals() {
            totalCredits = 0;
            totalCost = 0;
            totalDiscount = 0;

            document.querySelectorAll('#tableBody tr').forEach(row => {
                // Credits are always the same
                const credits = parseInt(row.getAttribute('data-credits')) || 0;
                totalCredits += credits;

                if (row.hasAttribute('data-subscription-id')) {
                    // For subscriptions, use the selected payment type
                    const paymentType = row.getAttribute('data-payment-type');
                    const monthlyCost = parseFloat(row.getAttribute('data-monthly')) || 0;
                    const yearlyCost = parseFloat(row.getAttribute('data-yearly')) || 0;
                    const discount = parseFloat(row.getAttribute('data-discount')) || 0;

                    totalCost += paymentType === 'm' ? monthlyCost : yearlyCost;
                    totalDiscount += discount;
                } else {
                    // For credits, use the fixed cost
                    const cost = parseFloat(row.getAttribute('data-cost')) || 0;
                    totalCost += cost;
                }
            });

            updateTotals();
        }

        // Track row to delete when delete button is clicked
        document.getElementById("serviceTable").addEventListener("click", function(event) {
            if (event.target.closest(".delete-item")) {
                rowToDelete = event.target.closest("tr");
            }
        });

        // Confirm Delete
        document.getElementById("confirmDelete").addEventListener("click", function() {
            if (rowToDelete) {
                const credits = parseInt(rowToDelete.getAttribute("data-credits")) || 0;

                if (rowToDelete.hasAttribute('data-subscription-id')) {
                    const subscriptionId = rowToDelete.getAttribute('data-subscription-id');
                    const paymentType = rowToDelete.getAttribute('data-payment-type');
                    const monthlyCost = parseFloat(rowToDelete.getAttribute('data-monthly')) || 0;
                    const yearlyCost = parseFloat(rowToDelete.getAttribute('data-yearly')) || 0;
                    const discount = parseFloat(rowToDelete.getAttribute('data-discount')) || 0;

                    totalCost -= paymentType === 'm' ? monthlyCost : yearlyCost;
                    totalDiscount -= discount;

                    // Remove subscription from tracking
                    const identifier = `${subscriptionId}-${paymentType}`;
                    addedSubscriptions.delete(identifier);
                } else {
                    const cost = parseFloat(rowToDelete.getAttribute('data-cost')) || 0;
                    totalCost -= cost;
                }

                totalCredits -= credits;
                rowToDelete.remove();
                updateTotals();
                rowToDelete = null;
                $('#deleteModal').modal('hide');
            }
        });

        // Update all totals and final amount
        function updateTotals() {
            const finalAmount = totalCost + (-totalDiscount);

            document.getElementById("totalCredits").textContent = totalCredits;
            document.getElementById("totalCost").textContent = `$${totalCost.toFixed(2)}`;
            document.getElementById("totalDiscount").textContent = `- $${Math.abs(totalDiscount).toFixed(2)}`;
            document.getElementById("finalAmount").textContent = finalAmount.toFixed(2);
            document.getElementById("total_amount").value = finalAmount.toFixed(2);
            document.getElementById("payment_type").value = selectedPaymentType;
            document.getElementById("selectedPaymentType").textContent = selectedPaymentType === 'm' ? 'Monthly (M)' : 'Yearly (Y)';

            // Set the total credits in hidden input
            document.getElementById("total_credits_input").value = totalCredits;

            // Collect all subscription IDs with their payment types
            let subscriptionIds = [];
            document.querySelectorAll('#tableBody tr[data-subscription-id]').forEach(row => {
                const subscriptionId = row.getAttribute('data-subscription-id');
                const paymentType = row.getAttribute('data-payment-type');
                subscriptionIds.push(`${subscriptionId}-${paymentType}`);
            });

            // Set the subscription IDs in hidden input (comma separated)
            document.getElementById("subscription_id_input").value = subscriptionIds.join(',');

            // Prepare order items for backend
            const items = [];
            document.querySelectorAll('#tableBody tr').forEach(row => {
                if (row.hasAttribute('data-subscription-id')) {
                    const paymentType = row.getAttribute('data-payment-type');
                    items.push({
                        type: 'subscription',
                        id: row.getAttribute('data-subscription-id'),
                        credits: parseInt(row.getAttribute('data-credits')) || 0,
                        amount: paymentType === 'm' ?
                            parseFloat(row.getAttribute('data-monthly')) || 0 :
                            parseFloat(row.getAttribute('data-yearly')) || 0,
                        discount: parseFloat(row.getAttribute('data-discount')) || 0,
                        payment_type: paymentType
                    });
                } else {
                    items.push({
                        type: 'credits',
                        credits: parseInt(row.getAttribute('data-credits')) || 0,
                        amount: parseFloat(row.getAttribute('data-cost')) || 0
                    });
                }
            });

            document.getElementById("order_items").value = JSON.stringify(items);

            // Enable/disable payment button based on amount
            document.getElementById('processPaymentBtn').disabled = finalAmount <= 0;
        }

        // Payment form validation
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            if (totalCost <= 0) {
                e.preventDefault();
                alert('Please add at least one item before proceeding with payment.');
            }
        });
    });



    // Initialize Stripe with your publishable key
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
    });

    // Add Stripe Element to the DOM
    cardElement.mount('#card-element');

    // Handle real-time validation errors from the card Element
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    const form = document.getElementById('paymentForm');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Disable submit button to prevent repeated submissions
        const submitButton = document.getElementById('processPaymentBtn');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        // Create payment method and submit form
        const {
            paymentMethod,
            error
        } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: form.querySelector('input[name="f_name"]').value + ' ' + form.querySelector('input[name="l_name"]').value,
                address: {
                    country: form.querySelector('select[name="country"]').value,
                    state: form.querySelector('select[name="state"]').value,
                    city: form.querySelector('select[name="city"]').value
                }
            }
        });

        if (error) {
            // Show error to customer
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            submitButton.disabled = false;
            submitButton.textContent = 'Process Payment ($' + document.getElementById('finalAmount').textContent + ')';
        } else {
            // Add payment method ID to form and submit
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);

            // Submit form
            form.submit();
        }
    });



    // Country/State/City dropdown functionality
    document.addEventListener("DOMContentLoaded", () => {
        loadCountries();
    });

    function loadCountries() {
        fetch("https://countriesnow.space/api/v0.1/countries")
            .then(response => response.json())
            .then(data => {
                const countryDropdown = document.getElementById("country");
                countryDropdown.innerHTML = '<option value="">Select Country</option>';

                data.data.forEach(country => {
                    const option = document.createElement("option");
                    option.value = country.country;
                    option.textContent = country.country;
                    countryDropdown.appendChild(option);
                });
            })
            .catch(error => console.error("Error loading countries:", error));
    }

    function loadStates() {
        const country = document.getElementById("country").value;
        const stateDropdown = document.getElementById("state");
        const cityDropdown = document.getElementById("city");

        stateDropdown.innerHTML = '<option value="">Select State</option>';
        cityDropdown.innerHTML = '<option value="">Select City</option>';

        if (country) {
            fetch("https://countriesnow.space/api/v0.1/countries/states", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        country: country
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data && data.data.states) {
                        data.data.states.forEach(state => {
                            const option = document.createElement("option");
                            option.value = state.name;
                            option.textContent = state.name;
                            stateDropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error("Error loading states:", error));
        }
    }

    function loadCities() {
        const country = document.getElementById("country").value;
        const state = document.getElementById("state").value;
        const cityDropdown = document.getElementById("city");

        cityDropdown.innerHTML = '<option value="">Select City</option>';

        if (country && state) {
            fetch("https://countriesnow.space/api/v0.1/countries/state/cities", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        country: country,
                        state: state
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data) {
                        data.data.forEach(city => {
                            const option = document.createElement("option");
                            option.value = city;
                            option.textContent = city;
                            cityDropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error("Error loading cities:", error));
        }
    }
</script>

@stop