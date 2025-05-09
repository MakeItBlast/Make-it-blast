@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/subscription.css') }}">
@stop

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
<div class="overlay" id="successOverlay" data-close="true">
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

<div class="container my-4 py-4">
    <!-- Active Subscription Table -->
    <div class="container">
        <div class="card p-4">
            <h2 class="mb-4">My Subscription Plans</h2>
            <div class="table-responsive">
                <table id="subscriptionTable" class="dataTable table table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Subscription Name</th>
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
                        @forelse($userSubscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->subscription->subsc_name }}</td>
                            <td>{{ $subscription->created_at->format('m/d/Y') }}</td>
                            <td>{{ $subscription->amt_type == 'monthly' ? $subscription->created_at->addMonth()->format('m/d/Y') : $subscription->created_at->addYear()->format('m/d/Y') }}</td>
                            <td>{{ ucfirst($subscription->amt_type) }}</td>
                            <td>${{ $subscription->amt_type == 'monthly' ? $subscription->subscription->monthly_cost : $subscription->subscription->yearly_cost }}</td>
                            <td>
                                <span class="badge bg-{{ $subscription->status == 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </td>
                            <td>{{ $subscription->subscription->credit_cost }}</td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm cancel-subscription" data-id="{{ $subscription->id }}" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionModal">
                                    Cancel
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No active subscriptions found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Subscription/Credit Purchase -->
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
                                data-yearly="{{ $subscription->yearly_cost }}"
                                data-is-free="{{ $subscription->monthly_cost == 0 && $subscription->yearly_cost == 0 ? 'true' : 'false' }}">
                                {{ $subscription->subsc_name }} -
                                @if($subscription->monthly_cost == 0 && $subscription->yearly_cost == 0)
                                $0.00 (One-Time)
                                @else
                                ${{ $subscription->monthly_cost }} (Monthly) / ${{ $subscription->yearly_cost }} (Yearly)
                                @endif
                            </option>
                            @endforeach
                        </select>
                        <button type="button" id="addSubscription" class="btn btn-outline-primary mt-2">Add To List</button>
                    </form>
                </div>

                <!-- Credits Section -->
                <div class="col-md-6 sub">
                    <h5 class="mt-2 mb-2">Buy Credits</h5>
                    <input type="number" id="creditAmount" class="form-control mt-2 mb-2" placeholder="Enter Credits" min="200" value="200">
                    <small class="text-muted">Minimum purchase: 200 credits ($10)</small>
                    <div class="input-group mb-2">
                        <span class="input-group-text">$0.05 per credit</span>
                        <input type="text" class="form-control" id="creditCostPreview" placeholder="$10.00" readonly>
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
                    <tbody id="tableBody"></tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th id="totalCredits">0</th>
                            <th id="totalCost">$0.00</th>
                            <th id="totalDiscount">$0.00</th>
                            <th></th>
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
            <form method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="total_amount" id="total_amount" value="0">
                <input type="hidden" name="payment_type" id="payment_type" value="">
                <input type="hidden" name="items" id="order_items" value="">
                <input type="hidden" name="subscription_id" id="subscription_id_input" value="">
                <input type="hidden" name="credits" id="total_credits_input" value="0">
                <input type="hidden" id="country_code" name="country_code" value="">

                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="f_name" value="{{ old('f_name', auth()->user()->f_name ?? '') }}" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="l_name" value="{{ old('l_name', auth()->user()->l_name ?? '') }}" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="row g-3 my-2">
                    <div class="col-md-4">
                        <select id="country" name="country" class="form-select" required>
                            <option value="">Select Country</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="state" class="form-select" name="state" required>
                            <option value="">Select State</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="city" class="form-select" name="city" required>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="existingCard" value="existing" checked>
                            <label class="form-check-label" for="existingCard">
                                Use Existing Card
                            </label>
                        </div>

                        <select id="existingCardSelect" class="form-select mb-3" name="card_id">
                            <option value="">Select a saved card</option>
                            @foreach($cardDetails as $card)
                            <option value="{{ $card->id }}"
                                data-card-number="{{ substr($card->card_number, -4) }}"
                                data-exp-date="{{ $card->exp_date }}"
                                data-priority="{{ $card->priority }}">
                                **** **** **** {{ substr($card->card_number, -4) }} (Exp: {{ $card->exp_date }})
                                @if($card->priority)
                                - Primary
                                @endif
                            </option>
                            @endforeach
                        </select>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="newCard" value="new">
                            <label class="form-check-label" for="newCard">
                                Use New Card
                            </label>
                        </div>
                    </div>
                </div>

                <!-- New Card Fields (Initially Hidden) -->
                <div id="newCardFields" style="display: none;">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div id="card-element" class="form-control p-2" style="height: 40px;"></div>
                            <div id="card-errors" role="alert" class="text-danger"></div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="saveCardCheckbox" name="save_card">
                                <label class="form-check-label" for="saveCardCheckbox">
                                    Save this card for future payments
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-success" id="processPaymentBtn">Process Payment ($<span id="finalAmount">0.00</span>)</button>
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
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Subscription Cancel Modal -->
<div class="modal fade" id="cancelSubscriptionModal" tabindex="-1" aria-labelledby="cancelSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelSubscriptionModalLabel">Confirm Cancelation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel this subscription? You will lose access to these credits when your current billing period ends.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmCancel">Yes, Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    // Close popups
    function closePopup() {
        const successOverlay = document.getElementById('successOverlay');
        if (successOverlay) successOverlay.style.display = 'none';
    }

    document.addEventListener('click', (event) => {
        if (event.target.dataset.close === "true") closePopup();
    });

    // Initialize DataTable
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        $('.dataTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [5, 10, 25, 50],
            pagingType: "simple_numbers",
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                paginate: {
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        // Handle subscription cancellation
        let subscriptionToCancel = null;
        $(document).on('click', '.cancel-subscription', function() {
            subscriptionToCancel = $(this).data('id');
            $('#cancelSubscriptionModal').modal('show');
        });

        $('#confirmCancel').click(function() {
            if (subscriptionToCancel) {
                $.ajax({
                    url: '/cancel-subscription',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        subscription_id: subscriptionToCancel
                    },
                    success: function(response) {
                        if (response.success) location.reload();
                        else alert(response.message || 'Failed to cancel subscription');
                    },
                    error: function() {
                        alert('An error occurred while canceling the subscription');
                    }
                });
            }
        });
    });

    const countryCodeMap = {
        'United States': 'US',
        'Afghanistan': 'AF',
        'Albania': 'AL',
        'Algeria': 'DZ',
        'Andorra': 'AD',
        'Angola': 'AO',
        'Antigua and Barbuda': 'AG',
        'Argentina': 'AR',
        'Armenia': 'AM',
        'Australia': 'AU',
        'Austria': 'AT',
        'Azerbaijan': 'AZ',
        'Bahamas': 'BS',
        'Bahrain': 'BH',
        'Bangladesh': 'BD',
        'Barbados': 'BB',
        'Belarus': 'BY',
        'Belgium': 'BE',
        'Belize': 'BZ',
        'Benin': 'BJ',
        'Bhutan': 'BT',
        'Bolivia': 'BO',
        'Bosnia and Herzegovina': 'BA',
        'Botswana': 'BW',
        'Brazil': 'BR',
        'Brunei': 'BN',
        'Bulgaria': 'BG',
        'Burkina Faso': 'BF',
        'Burundi': 'BI',
        'Cabo Verde': 'CV',
        'Cambodia': 'KH',
        'Cameroon': 'CM',
        'Canada': 'CA',
        'Central African Republic': 'CF',
        'Chad': 'TD',
        'Chile': 'CL',
        'China': 'CN',
        'Colombia': 'CO',
        'Comoros': 'KM',
        'Congo (Congo-Brazzaville)': 'CG',
        'Costa Rica': 'CR',
        'Croatia': 'HR',
        'Cuba': 'CU',
        'Cyprus': 'CY',
        'Czechia (Czech Republic)': 'CZ',
        'Denmark': 'DK',
        'Djibouti': 'DJ',
        'Dominica': 'DM',
        'Dominican Republic': 'DO',
        'Ecuador': 'EC',
        'Egypt': 'EG',
        'El Salvador': 'SV',
        'Equatorial Guinea': 'GQ',
        'Eritrea': 'ER',
        'Estonia': 'EE',
        'Eswatini': 'SZ',
        'Ethiopia': 'ET',
        'Fiji': 'FJ',
        'Finland': 'FI',
        'France': 'FR',
        'Gabon': 'GA',
        'Gambia': 'GM',
        'Georgia': 'GE',
        'Germany': 'DE',
        'Ghana': 'GH',
        'Greece': 'GR',
        'Grenada': 'GD',
        'Guatemala': 'GT',
        'Guinea': 'GN',
        'Guinea-Bissau': 'GW',
        'Guyana': 'GY',
        'Haiti': 'HT',
        'Honduras': 'HN',
        'Hungary': 'HU',
        'Iceland': 'IS',
        'India': 'IN',
        'Indonesia': 'ID',
        'Iran': 'IR',
        'Iraq': 'IQ',
        'Ireland': 'IE',
        'Israel': 'IL',
        'Italy': 'IT',
        'Jamaica': 'JM',
        'Japan': 'JP',
        'Jordan': 'JO',
        'Kazakhstan': 'KZ',
        'Kenya': 'KE',
        'Kiribati': 'KI',
        'Korea, North': 'KP',
        'Korea, South': 'KR',
        'Kosovo': 'XK',
        'Kuwait': 'KW',
        'Kyrgyzstan': 'KG',
        'Laos': 'LA',
        'Latvia': 'LV',
        'Lebanon': 'LB',
        'Lesotho': 'LS',
        'Liberia': 'LR',
        'Libya': 'LY',
        'Liechtenstein': 'LI',
        'Lithuania': 'LT',
        'Luxembourg': 'LU',
        'Madagascar': 'MG',
        'Malawi': 'MW',
        'Malaysia': 'MY',
        'Maldives': 'MV',
        'Mali': 'ML',
        'Malta': 'MT',
        'Marshall Islands': 'MH',
        'Mauritania': 'MR',
        'Mauritius': 'MU',
        'Mexico': 'MX',
        'Micronesia': 'FM',
        'Moldova': 'MD',
        'Monaco': 'MC',
        'Mongolia': 'MN',
        'Montenegro': 'ME',
        'Morocco': 'MA',
        'Mozambique': 'MZ',
        'Myanmar (formerly Burma)': 'MM',
        'Namibia': 'NA',
        'Nauru': 'NR',
        'Nepal': 'NP',
        'Netherlands': 'NL',
        'New Zealand': 'NZ',
        'Nicaragua': 'NI',
        'Niger': 'NE',
        'Nigeria': 'NG',
        'North Macedonia': 'MK',
        'Norway': 'NO',
        'Oman': 'OM',
        'Pakistan': 'PK',
        'Palau': 'PW',
        'Palestine State': 'PS',
        'Panama': 'PA',
        'Papua New Guinea': 'PG',
        'Paraguay': 'PY',
        'Peru': 'PE',
        'Philippines': 'PH',
        'Poland': 'PL',
        'Portugal': 'PT',
        'Qatar': 'QA',
        'Romania': 'RO',
        'Russia': 'RU',
        'Rwanda': 'RW',
        'Saint Kitts and Nevis': 'KN',
        'Saint Lucia': 'LC',
        'Saint Vincent and the Grenadines': 'VC',
        'Samoa': 'WS',
        'San Marino': 'SM',
        'Sao Tome and Principe': 'ST',
        'Saudi Arabia': 'SA',
        'Senegal': 'SN',
        'Serbia': 'RS',
        'Seychelles': 'SC',
        'Sierra Leone': 'SL',
        'Singapore': 'SG',
        'Slovakia': 'SK',
        'Slovenia': 'SI',
        'Solomon Islands': 'SB',
        'Somalia': 'SO',
        'South Africa': 'ZA',
        'South Sudan': 'SS',
        'Spain': 'ES',
        'Sri Lanka': 'LK',
        'Sudan': 'SD',
        'Suriname': 'SR',
        'Sweden': 'SE',
        'Switzerland': 'CH',
        'Syria': 'SY',
        'Taiwan': 'TW',
        'Tajikistan': 'TJ',
        'Tanzania': 'TZ',
        'Thailand': 'TH',
        'Timor-Leste': 'TL',
        'Togo': 'TG',
        'Tonga': 'TO',
        'Trinidad and Tobago': 'TT',
        'Tunisia': 'TN',
        'Turkey': 'TR',
        'Turkmenistan': 'TM',
        'Tuvalu': 'TV',
        'Uganda': 'UG',
        'Ukraine': 'UA',
        'United Arab Emirates': 'AE',
        'United Kingdom': 'GB',
        'Uruguay': 'UY',
        'Uzbekistan': 'UZ',
        'Vanuatu': 'VU',
        'Vatican City': 'VA',
        'Venezuela': 'VE',
        'Vietnam': 'VN',
        'Yemen': 'YE',
        'Zambia': 'ZM',
        'Zimbabwe': 'ZW'
    };

    // Initialize variables
    let totalCredits = 0,
        totalCost = 0,
        totalDiscount = 0;
    let addedSubscriptions = new Set();
    let rowToDelete = null;
    const creditRate = 0.05; // $0.05 per credit
    let selectedPaymentType = 'm';
    let formSubmitted = false;
    let paymentMethod = null;

    // Initialize Stripe
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

    // Payment method selection toggle
    $('input[name="payment_method"]').change(function() {
        if ($(this).val() === 'new') {
            $('#newCardFields').show();
            $('#existingCardSelect').prop('disabled', true);
            cardElement.mount('#card-element');
        } else {
            $('#newCardFields').hide();
            $('#existingCardSelect').prop('disabled', false);
            cardElement.unmount();
        }
    });

    // Add Subscription to Table
    document.getElementById("addSubscription").addEventListener("click", function() {
        const select = document.getElementById("subscriptionSelect");
        const selectedOption = select.options[select.selectedIndex];

        if (!selectedOption.value) {
            alert("Please select a subscription!");
            return;
        }

        const subscriptionId = selectedOption.value;
        const isFree = selectedOption.getAttribute("data-is-free") === 'true';
        const paymentType = isFree ? 'm' : selectedPaymentType;
        const subscriptionIdentifier = `${subscriptionId}-${paymentType}`;

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
        const duration = selectedOption.getAttribute("data-duration") || (isFree ? 'One-Time' : '30 days');
        const appliedDiscount = paymentType === 'y' ? discount : 0;
        const cost = paymentType === 'm' ? monthlyCost : yearlyCost;

        const row = `
        <tr data-subscription-id="${subscriptionId}" data-payment-type="${paymentType}" data-credits="${credits}"
            data-monthly="${monthlyCost}" data-yearly="${yearlyCost}" data-discount="${discount}" data-is-free="${isFree}">
            <td>${subscName}</td>
            <td>${duration}</td>
            <td>${credits}</td>
            <td class="price-display">$${cost.toFixed(2)}</td>
            <td class="text-danger">- $${Math.abs(appliedDiscount).toFixed(2)}</td>
            <td>${isFree ? 'One-Time' : `
                <select class="form-select payment-type">
                    <option value="m" ${paymentType === 'm' ? 'selected' : ''}>Monthly</option>
                    <option value="y" ${paymentType === 'y' ? 'selected' : ''}>Yearly</option>
                </select>`}
            </td>
            <td>
                <button class="btn btn-outline-danger btn-sm rounded-circle delete-item" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        </tr>`;
        document.getElementById("tableBody").insertAdjacentHTML("beforeend", row);

        totalCredits += credits;
        totalCost += cost;
        totalDiscount += appliedDiscount;
        updateTotals();
        select.selectedIndex = 0;
    });

    // Add Credits to Table
    document.getElementById("addCredits").addEventListener("click", function() {
        const creditInput = document.getElementById("creditAmount");
        const creditAmount = parseInt(creditInput.value);
        const creditCost = creditAmount * creditRate; // $0.05 per credit

        // Minimum $10 validation (200 credits)
        if (creditCost < 10) {
            alert("Minimum credit purchase is $10 (200 credits)");
            return;
        }

        if (!creditAmount || creditAmount <= 0) {
            alert("Please enter a valid credit amount!");
            return;
        }

        const row = `
        <tr data-credits="${creditAmount}" data-cost="${creditCost.toFixed(2)}">
            <td>Added Credits</td>
            <td>-</td>
            <td>${creditAmount}</td>
            <td>$${creditCost.toFixed(2)}</td>
            <td>-</td>
            <td>-</td>
            <td>
                <button class="btn btn-outline-danger btn-sm rounded-circle delete-item" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        </tr>`;
        document.getElementById("tableBody").insertAdjacentHTML("beforeend", row);

        totalCredits += creditAmount;
        totalCost += creditCost;
        updateTotals();
        creditInput.value = '200'; // Reset to minimum
        document.getElementById('creditCostPreview').value = '$10.00';
    });

    // Update credit cost preview dynamically
    document.getElementById("creditAmount").addEventListener("input", function() {
        const creditAmount = parseInt(this.value) || 0;
        const cost = creditAmount * creditRate; // $0.05 per credit
        document.getElementById("creditCostPreview").value = `$${cost.toFixed(2)}`;
    });

    // Payment type change handler
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('payment-type')) {
            const row = e.target.closest('tr');
            const paymentType = e.target.value;

            if (!row.hasAttribute('data-subscription-id') || row.getAttribute('data-is-free') === 'true') return;

            const subscriptionId = row.getAttribute('data-subscription-id');
            const oldPaymentType = row.getAttribute('data-payment-type');
            const oldIdentifier = `${subscriptionId}-${oldPaymentType}`;
            const newIdentifier = `${subscriptionId}-${paymentType}`;

            if (addedSubscriptions.has(newIdentifier)) {
                alert("This subscription with the selected payment type is already added!");
                e.target.value = oldPaymentType;
                return;
            }

            addedSubscriptions.delete(oldIdentifier);
            addedSubscriptions.add(newIdentifier);
            row.setAttribute('data-payment-type', paymentType);

            const monthlyCost = parseFloat(row.getAttribute('data-monthly')) || 0;
            const yearlyCost = parseFloat(row.getAttribute('data-yearly')) || 0;
            const discount = parseFloat(row.getAttribute('data-discount')) || 0;
            const appliedDiscount = paymentType === 'y' ? discount : 0;

            row.querySelector('.price-display').textContent = paymentType === 'm' ? `$${monthlyCost.toFixed(2)}` : `$${yearlyCost.toFixed(2)}`;
            row.querySelector('.text-danger').textContent = `- $${Math.abs(appliedDiscount).toFixed(2)}`;

            selectedPaymentType = paymentType;
            recalculateTotals();
        }
    });

    function recalculateTotals() {
        totalCredits = totalCost = totalDiscount = 0;

        document.querySelectorAll('#tableBody tr').forEach(row => {
            const credits = parseInt(row.getAttribute('data-credits')) || 0;
            totalCredits += credits;

            if (row.hasAttribute('data-subscription-id')) {
                const paymentType = row.getAttribute('data-payment-type');
                const monthlyCost = parseFloat(row.getAttribute('data-monthly')) || 0;
                const yearlyCost = parseFloat(row.getAttribute('data-yearly')) || 0;
                const discount = parseFloat(row.getAttribute('data-discount')) || 0;
                totalCost += paymentType === 'm' ? monthlyCost : yearlyCost;
                totalDiscount += paymentType === 'y' ? discount : 0;
            } else {
                totalCost += parseFloat(row.getAttribute('data-cost')) || 0;
            }
        });
        updateTotals();
    }

    // Delete row functionality
    document.getElementById("serviceTable").addEventListener("click", function(event) {
        if (event.target.closest(".delete-item")) {
            event.preventDefault();
            rowToDelete = event.target.closest("tr");
            $('#deleteModal').modal('show');
        }
    });

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
                totalDiscount -= paymentType === 'y' ? discount : 0;
                addedSubscriptions.delete(`${subscriptionId}-${paymentType}`);
            } else {
                totalCost -= parseFloat(rowToDelete.getAttribute('data-cost')) || 0;
            }

            totalCredits -= credits;
            rowToDelete.remove();
            updateTotals();
            rowToDelete = null;
            $('#deleteModal').modal('hide');
        }
    });

    function updateTotals() {
        const finalAmount = totalCost - totalDiscount;
        document.getElementById("totalCredits").textContent = totalCredits;
        document.getElementById("totalCost").textContent = `$${totalCost.toFixed(2)}`;
        document.getElementById("totalDiscount").textContent = `- $${Math.abs(totalDiscount).toFixed(2)}`;
        document.getElementById("finalAmount").textContent = finalAmount.toFixed(2);
        document.getElementById("total_amount").value = finalAmount.toFixed(2);
        document.getElementById("payment_type").value = selectedPaymentType;
        document.getElementById("total_credits_input").value = totalCredits;

        const subscriptionIds = Array.from(document.querySelectorAll('#tableBody tr[data-subscription-id]'))
            .map(row => `${row.getAttribute('data-subscription-id')}-${row.getAttribute('data-payment-type')}`);
        document.getElementById("subscription_id_input").value = subscriptionIds.join(',');

        const items = Array.from(document.querySelectorAll('#tableBody tr')).map(row => {
            if (row.hasAttribute('data-subscription-id')) {
                const paymentType = row.getAttribute('data-payment-type');
                const discount = parseFloat(row.getAttribute('data-discount')) || 0;
                const isFree = row.getAttribute('data-is-free') === 'true';
                return {
                    type: 'subscription',
                    id: row.getAttribute('data-subscription-id'),
                    name: row.querySelector('td:first-child').textContent.trim(),
                    credits: parseInt(row.getAttribute('data-credits')) || 0,
                    amount: isFree ? 0 : (paymentType === 'm' ? parseFloat(row.getAttribute('data-monthly')) || 0 : parseFloat(row.getAttribute('data-yearly')) || 0),
                    discount: paymentType === 'y' ? discount : 0,
                    payment_type: isFree ? 'one-time' : paymentType
                };
            }
            return {
                type: 'credits',
                name: 'Added Credits',
                credits: parseInt(row.getAttribute('data-credits')) || 0,
                amount: parseFloat(row.getAttribute('data-cost')) || 0
            };
        });

        document.getElementById("order_items").value = JSON.stringify(items);
        document.getElementById('processPaymentBtn').disabled = finalAmount < 0;
    }

    // Stripe payment handling
    cardElement.on('change', function(event) {
        document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
    });

    // Process Payment
    document.getElementById('processPaymentBtn').addEventListener('click', async function() {
        const submitButton = this;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        const countrySelect = document.getElementById('country');
        const selectedCountry = countrySelect.options[countrySelect.selectedIndex].text;
        const countryCode = countryCodeMap[selectedCountry] || '';
        document.getElementById('country_code').value = countryCode;

        if (!countryCode) {
            document.getElementById('card-errors').textContent = 'Please select a valid country';
            submitButton.disabled = false;
            submitButton.innerHTML = 'Process Payment ($' + document.getElementById('finalAmount').textContent + ')';
            return;
        }

        const paymentMethodType = $('input[name="payment_method"]:checked').val();
        const saveCard = $('#saveCardCheckbox').is(':checked');
        const cardId = $('#existingCardSelect').val();

        try {
            // For new card: create PaymentMethod first
            if (paymentMethodType === 'new') {
                const {
                    paymentMethod: stripePaymentMethod,
                    error: pmError
                } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                    billing_details: {
                        name: $('input[name="f_name"]').val() + ' ' + $('input[name="l_name"]').val(),
                        address: {
                            country: countryCode,
                            state: $('#state').val(),
                            city: $('#city').val()
                        }
                    }
                });

                if (pmError) throw new Error(pmError.message);
                paymentMethod = stripePaymentMethod.id;
            }

            // Prepare subscription items
            const subscriptionItems = [];
            $('#tableBody tr').each(function() {
                const row = $(this);
                if (row.data('subscription-id')) {
                    subscriptionItems.push({
                        name: row.find('td:eq(0)').text().trim(),
                        pay_type: row.find('.payment-type').val() || 'm',
                        credits: parseInt(row.data('credits')) || 0,
                        subsc_id: row.data('subscription-id')
                    });
                } else {
                    subscriptionItems.push({
                        name: 'Added Credits',
                        pay_type: 'one-time',
                        credits: parseInt(row.data('credits')) || 0
                    });
                }
            });

            // Prepare payment data
            const paymentData = {
                f_name: $('input[name="f_name"]').val(),
                l_name: $('input[name="l_name"]').val(),
                total_amount: parseFloat($('#total_amount').val()),
                payment_type: $('#payment_type').val(),
                items: $('#order_items').val(),
                subscription_id: $('#subscription_id_input').val(),
                credits: parseInt($('#total_credits_input').val()) || 0,
                country: $('#country').val(),
                country_code: countryCode,
                state: $('#state').val(),
                city: $('#city').val(),
                payment_method: paymentMethodType,
                save_card: saveCard,
                card_id: cardId,
                stripeToken: paymentMethod
            };

            // Make the AJAX request
            const response = await $.ajax({
                url: '{{ route("process-payment-and-subscription") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                data: JSON.stringify({
                    subscription_items: subscriptionItems,
                    payment_data: paymentData
                })
            });

            // Handle 3D Secure if needed
            if (response.requires_action) {
                const {
                    error,
                    paymentIntent
                } = await stripe.confirmCardPayment(response.payment_intent_client_secret);
                if (error) throw error;

                // Payment succeeded after 3D Secure
                formSubmitted = true;
                window.location.href = response.redirect_url || '{{ route("payment.success") }}';
            }
            // Success case
            else if (response.success) {
                formSubmitted = true;
                window.location.href = response.redirect_url || '{{ route("payment.success") }}';
            }
            // Failure case
            else {
                throw new Error(response.message || "Payment failed");
            }

        } catch (error) {
            console.error('Payment error:', error);
            console.log('ab', error);
            let errorMessage = 'Payment failed. Please try again.';

            if (error.responseJSON) {
                errorMessage = error.responseJSON.message || errorMessage;
                if (error.responseJSON.errors) {
                    errorMessage += ': ' + Object.values(error.responseJSON.errors).join(', ');
                }
            } else if (error.message) {
                errorMessage = error.message;
            }

            document.getElementById('card-errors').textContent = errorMessage;
            submitButton.disabled = false;
            submitButton.innerHTML = 'Process Payment ($' + document.getElementById('finalAmount').textContent + ')';
        }
    });

    // Handle beforeunload
    window.addEventListener('beforeunload', function(e) {
        if (document.getElementById('tableBody').children.length > 0 && !formSubmitted) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    // Load countries
    function loadCountries() {
        fetch("https://countriesnow.space/api/v0.1/countries")
            .then(response => response.json())
            .then(data => {
                const countryDropdown = document.getElementById("country");
                countryDropdown.innerHTML = '<option value="">Select Country</option>';

                const usaIndex = data.data.findIndex(country => country.country === "United States");
                if (usaIndex !== -1) {
                    const usa = data.data[usaIndex];
                    countryDropdown.innerHTML += `<option value="${usa.country}" style="font-weight: bold;">${usa.country}</option><option disabled></option>`;
                    data.data.splice(usaIndex, 1);
                }

                data.data.sort((a, b) => a.country.localeCompare(b.country)).forEach(country => {
                    countryDropdown.innerHTML += `<option value="${country.country}">${country.country}</option>`;
                });
            })
            .catch(error => {
                console.error("Error loading countries:", error);
                const countryDropdown = document.getElementById("country");
                countryDropdown.innerHTML = '<option value="">Select Country</option>';
                Object.keys(countryCodeMap).sort().forEach(country => {
                    const option = `<option value="${country}" ${country === "United States" ? 'style="font-weight: bold;"' : ''}>${country}</option>`;
                    country === "United States" ? countryDropdown.insertAdjacentHTML('afterbegin', option) : countryDropdown.innerHTML += option;
                });
            });
    }

    function loadStates() {
        const country = document.getElementById("country").value;
        const stateDropdown = document.getElementById("state");
        const cityDropdown = document.getElementById("city");

        stateDropdown.innerHTML = cityDropdown.innerHTML = '<option value="">Select</option>';

        if (country) {
            fetch("https://countriesnow.space/api/v0.1/countries/states", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        country
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data && data.data.states) {
                        data.data.states.forEach(state => {
                            stateDropdown.innerHTML += `<option value="${state.name}">${state.name}</option>`;
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
                        country,
                        state
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data) {
                        data.data.forEach(city => {
                            cityDropdown.innerHTML += `<option value="${city}">${city}</option>`;
                        });
                    }
                })
                .catch(error => console.error("Error loading cities:", error));
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        loadCountries();
        document.getElementById("country").addEventListener("change", loadStates);
        document.getElementById("state").addEventListener("change", loadCities);

        // Set default payment method
        $('input[name="payment_method"][value="existing"]').prop('checked', true);
        $('#existingCardSelect').prop('disabled', false);

        // Initialize credit preview
        document.getElementById('creditCostPreview').value = '$10.00';
    });
</script>
@stop