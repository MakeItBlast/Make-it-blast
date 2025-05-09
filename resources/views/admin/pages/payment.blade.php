@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/payment-info.css') }}">
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
    <div class="form-section p-4">
        <h4 class="mt-2 mb-2">Payment Information</h4>
        <form method="POST" action="{{ url('add-card-detail') }}">
            @csrf <!-- CSRF Token for security -->
            <input type="hidden" name="id" value="{{$cardDetailsUpd->id ?? ''}}">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="f_name"
                        value="{{ old('f_name', $cardDetailsUpd->f_name ?? '') }}"
                        placeholder="First Name">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="l_name" value="{{old('l_name',$cardDetailsUpd->l_name ?? '')}}" placeholder="Last Name">
                </div>

            </div>

            <div class="row g-3 my-2">
                <!-- Country -->
                <div class="col-md-4">

                    <select id="country" class="form-select" onchange="loadStates()">
                        <option value="">Select Country</option>
                    </select>
                </div>

                <!-- State -->
                <div class="col-md-4">
                    <select id="state" class="form-select" name="state" onchange="loadCities()">
                        <option value="">Select State</option>
                    </select>
                </div>

                <!-- City -->
                <div class="col-md-4">
                    <select id="city" class="form-select" name="city" value="">
                        <option value="">Select City</option>
                    </select>
                </div>
            </div>


            <div class="row mt-3">
                <!-- Credit Card Number -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="card_number" value="{{old('card_number', $cardDetailsUpd->card_number ?? '')}}" placeholder="CreditCard" maxlength="16" pattern="[0-9]{13,16}" title="Enter a valid 13 to 16-digit card number" required>
                </div>

                <!-- Expiration Date -->
                <div class="col-md-4">
                    <input type="text" name="exp_date" value="{{old('exp_date',$cardDetailsUpd->exp_date ?? '')}}" id="exp_date" class="form-control" placeholder="Expiration Date" required>
                </div>

                <!-- CVV -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="cvv" value="{{old('cvv',$cardDetailsUpd->cvv ?? '')}}" placeholder="CVV" maxlength="4" pattern="[0-9]{3,4}" title="Enter a valid 3 or 4-digit CVV" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save Card</button>
        </form>
    </div>

    <!-- Saved Credit Cards -->
    <div class="tab-bg mt-4">
        <h2 class="my-4">Saved Cards</h2>
        <div class="table-responsive">
            <table class="dataTable table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Credit Card Number</th>
                        <th>Expiration</th>
                        <th>Default</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cardDetails as $card)
                    <tr>
                        <td>{{ $card->f_name }}</td>
                        <td>{{ $card->l_name }}</td>
                        <td>{{ $card->city }}</td>
                        <td>{{ $card->state }}</td>
                        <td>XXXX-XXXX-XXXX-{{ substr($card->card_number, -4) }}</td>
                        <td>{{ $card->exp_date }}</td>

                        <!-- Toggle Switch -->
                        <td>
                            <label class="switch" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Only one card can be set as default">
                                <input type="checkbox" class="priority-toggle" data-id="{{ $card->id }}" {{ $card->priority == 1 ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>

                        <!-- Operation Buttons -->
                        <td>
                            <div class="action-btns">
                                <a class="btn btn-sm edit-btn" href="{{url('update-card-info/'.$card->id)}}"> <i class="fa-solid fa-pencil"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Dummy row to prevent DataTables column mismatch -->
                    <tr class="d-none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-center">No Cards available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
    </div>


    <!-- Payment History -->
    <div class="tab-bg mt-4">

        <h5 class="mt-4">My Payment History</h5>
        <div class="table-responsive">
            <table class="dataTable table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Description of Service</th>
                        <th>Processed Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($invoice as $invoice)
                    @php
                    $description = json_decode($invoice->description, true);
                    $name = $description[0]['name'] ?? 'N/A';
                    @endphp
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</td>
                        <td>Completed</td>
                        <td>${{ number_format($invoice->total, 2) }}</td>
                        <td>
                            <div class="action-btns">
                                <button
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#invoiceModal"
                                    data-invoice='@json($invoice)'
                                    data-user_invoice='@json($user_invoice)'
                                    data-user_invoice_meta='@json($user_invoice_meta)'>
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Dummy row to prevent DataTables column mismatch -->
                    <tr class="d-none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-center">No Invoices available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>




    <!-- Footer Summary -->

    <div class=" tab-bg d-flex justify-content-center align-items-center mt-3">
        <div>
            <span>Total Campaigns: <strong>3</strong></span> |
            <span>Total Blasts: <strong>17</strong></span> |
            <span>Total Recipients: <strong>1,603</strong></span> |
            <span>Total Success: <strong>3,190</strong></span> |
            <span>Total Failed: <strong>16</strong></span> |
            <span>Total Replies: <strong>943</strong></span>
        </div>
    </div>
</div>



<!-- modal boxes -->

<!-- edit modal  -->

<!-- Invoice Preview Modal -->
<div class="modal fade p-4" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="invoiceContent"></div>
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if(isset($card))
            <form method="POST" action="{{ url('delete-card-info/'.$card->id) }}" id="deleteCardForm">
                @csrf
                @method('DELETE') <!-- This tells Laravel to treat it as a DELETE request -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this credit card?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    //code to on click add the url on the form
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-card-btn");
        const deleteForm = document.getElementById("deleteCardForm");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                const deleteUrl = this.getAttribute("data-url");
                deleteForm.setAttribute("action", deleteUrl);
            });
        });
    });


    // for invoice preview
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceModal = document.getElementById('invoiceModal');
        const invoiceContent = document.getElementById('invoiceContent');

        if (!invoiceModal || !invoiceContent) return;

        invoiceModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            try {
                // Parse all invoice data
                const invoice = JSON.parse(button.getAttribute('data-invoice'));
                const userInvoice = JSON.parse(button.getAttribute('data-user_invoice'));
                const userInvoiceMetaArray = JSON.parse(button.getAttribute('data-user_invoice_meta'));

                // Extract the meta object from the array
                const userInvoiceMeta = userInvoiceMetaArray[0] || {};

                // Get service name from description
                let serviceName = 'N/A';
                try {
                    const description = JSON.parse(invoice.description);
                    serviceName = description[0]?.name || invoice.description || 'N/A';
                } catch (e) {
                    serviceName = invoice.description || 'N/A';
                }

                // Format invoice date
                const formattedDate = new Date(invoice.created_at).toLocaleDateString('en-GB') || 'N/A';

                // Extract company information
                const companyName = (userInvoiceMeta.company_name || 'Customer Name').toString().trim();
                const billingEmail = (userInvoiceMeta.billing_email || 'customer@example.com').toString().trim();

                // Build the invoice HTML
                invoiceContent.innerHTML = `
            <div class="invoice-container" style="max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif;">
                <div class="mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5><strong>Make It Blast</strong></h5>
                                    <p class="mb-1">123 Business Street<br>City, State 10001</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <img src="{{ asset('media/Blast Logo.png') }}" alt="Company Logo" 
                                 style="height: 150px;" onerror="this.style.display='none'">
                        </div>
                        <div class="col-4 text-end">
                            <h6><strong>Invoice #${invoice.invoice_number || 'N/A'}</strong></h6>
                            <p class="mb-1">Date: ${formattedDate}</p>
                            <p>Status: <strong class="text-success">${invoice.status || 'Completed'}</strong></p>
                        </div>
                    </div>
                </div>

                <hr style="border-top: 1px solid #ddd; margin: 20px 0;">

                <div class="mb-4">
                    <h4 style="margin-bottom: 10px; font-size: 1.1rem;"><strong>Billed To:</strong></h4>
                    <p style="margin: 5px 0; font-size: 0.95rem;"><strong>${companyName}</strong></p>
                    <p style="margin: 5px 0; font-size: 0.95rem;">${billingEmail}</p>
                    <p style="margin: 5px 0; font-size: 0.95rem;">${userInvoiceMeta.address || ''}</p>
                    <p style="margin: 5px 0; font-size: 0.95rem;">
                        ${[userInvoiceMeta.city, userInvoiceMeta.state, userInvoiceMeta.zipcode].filter(Boolean).join(', ')}
                    </p>
                    <p style="margin: 5px 0; font-size: 0.95rem;">${userInvoiceMeta.country || ''}</p>
                </div>

                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Invoice #</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Description</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Date</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Status</th>
                            <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">${invoice.invoice_number || 'N/A'}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">${serviceName}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">${formattedDate}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">${invoice.status || 'Completed'}</td>
                            <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">$${parseFloat(invoice.total || 0).toFixed(2)}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="text-align: right; margin-top: 30px;">
                    <h3>Thank you for your business!</h3>
                    <p>This invoice was generated automatically.</p>
                </div>
            </div>`;

            } catch (e) {
                invoiceContent.innerHTML = `
                <div class="alert alert-danger">
                    <h4>Error Loading Invoice</h4>
                    <p>Please try again or contact support</p>
                </div>`;
            }
        });
    });


    // for data Tables 
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
                search: "", // Removes "Search:" label
                lengthMenu: "Show _MENU_ entries",
                paginate: {
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            },
            initComplete: function() {
                $('.dataTables_filter input[type="search"]')
                    .attr('placeholder', 'Search here...')
                    .css('width', '200px'); // optional styling
            },
            drawCallback: function() {
                $('.d-none').hide(); // Hide dummy rows
            }
        });
    });

    // for synamically fetching contries state and city 

    document.addEventListener("DOMContentLoaded", () => {
        loadCountries();
    });

    // Load all countries
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

    // Load states based on selected country
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
                    data.data.states.forEach(state => {
                        const option = document.createElement("option");
                        option.value = state.name;
                        option.textContent = state.name;
                        stateDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error("Error loading states:", error));
        }
    }

    // Load cities based on selected state
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
                    data.data.forEach(city => {
                        const option = document.createElement("option");
                        option.value = city;
                        option.textContent = city;
                        cityDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error("Error loading cities:", error));
        }
    }

    // for switching card status 

    document.querySelectorAll('.priority-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck all other toggles
                document.querySelectorAll('.priority-toggle').forEach(otherToggle => {
                    if (otherToggle !== this) {
                        otherToggle.checked = false;
                    }
                });

                // Trigger the AJAX call
                const cardId = this.dataset.id;

                $.ajax({
                    url: '{{ url("/toggle-default-card") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        cardId: cardId
                    },
                    success: function(response) {
                        alert('Priority updated successfully!');
                        console.log(response);
                    },
                    error: function(xhr) {
                        alert('Something went wrong!');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
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


    // For tooltip 
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>


@stop