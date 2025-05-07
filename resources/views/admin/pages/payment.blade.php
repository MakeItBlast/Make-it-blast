@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/payment-info.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

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
            <table id="myDataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Credit Card Number</th>
                        <th>Expiration</th>
                        <th>Active</th>
                        <th>Default</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cardDetails as $card)
                    <tr>
                        <td>{{ $card->f_name }}</td>
                        <td>{{ $card->l_name }}</td>
                        <td>{{ $card->city }}</td>
                        <td>{{ $card->state }}</td>
                        <td>XXXX-XXXX-XXXX-{{ substr($card->card_number, -4) }}</td> <!-- Masking CC -->
                        <td>{{ \Carbon\Carbon::parse($card->exp_date)->format('m/y') }}</td> <!-- Formatting Expiry -->
                        <td>{{ $card->active ? 'Yes' : 'No' }}</td>
                        <td>{{ $card->is_default ? 'Yes' : 'No' }}</td>
                        <td>

                            <a class="edit-icon" href="{{url('update-card-info/'.$card->id)}}"> <i class="fa-solid fa-pencil"></i></a>

                            <a href="#" class="delete-card-btn" data-url="{{ url('delete-card-info/'.$card->id) }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


    <!-- Payment History -->
    <div class="tab-bg mt-4">

        <h5 class="mt-4">My Payment History</h5>
        <div class="table-responsive">
            <table id="paymentTable" class="dataTable table table-bordered">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Credit Card Number</th>
                        <th>Description of Service</th>
                        <th>Processed Date</th>
                        <th>Total</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0909865</td>
                        <td>XXXX-XXXX-XXXX-2453</td>
                        <td>Premium Subscription</td>
                        <td>1/23/2026</td>
                        <td>$39.99</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>0909866</td>
                        <td>XXXX-XXXX-XXXX-1234</td>
                        <td>Basic Subscription</td>
                        <td>2/15/2026</td>
                        <td>$19.99</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>0909867</td>
                        <td>XXXX-XXXX-XXXX-5678</td>
                        <td>Annual Subscription</td>
                        <td>3/10/2026</td>
                        <td>$99.99</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
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


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="" id="deleteCardForm">
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

    // for data tables

$(document).ready(function() {
        $('.dataTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [5, 10, 25, 50],
        "pagingType": "simple_numbers",  // Only prev/next + numbers
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "paginate": {
                "next": "<i class='fas fa-chevron-right'></i>",     // Next icon
                "previous": "<i class='fas fa-chevron-left'></i>"   // Previous icon
            }
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


    // for card form validation
    // document.addEventListener("DOMContentLoaded", () => {
    //     const expDateInput = document.getElementById("exp_date");

    //     expDateInput.addEventListener("change", () => {
    //         const selectedDate = expDateInput.value; // Format: YYYY-MM
    //         if (selectedDate) {
    //             const [year, month] = selectedDate.split("-");
    //             expDateInput.type = "text"; // Switch to text type
    //             expDateInput.value = `${month}/${year.slice(-2)}`; // Display as MM/YY
    //         }
    //     });

    //     // Reset back to "month" input type on focus
    //     expDateInput.addEventListener("focus", () => {
    //         expDateInput.type = "month";
    //     });
    // });


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