@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/my-contacts.css') }}">


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



    <div id="multiScreenContainer">
        <!-- Screen 1 - Matches Provided Layout -->
        <div class="screen active" id="screen1">

            <div class="tab-bg mb-4">
                <h2 class="fw-bold mt-4">My Contacts</h2>
                <h3 class="fw-bold mt-4 mb-4">Contact List</h3>
                <div class="table-responsive">
                    <table class="dataTable table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>S.No.</th>
                                <th>Contact Type</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>SMS</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $incr = 1; @endphp

                            @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $incr }}</td>
                                <td>{{ $contact->contactType->contact_type }}</td>
                                <td>{{ $contact->c_lname }}</td>
                                <td>{{ $contact->c_fname }}</td>
                                <td>{{ $contact->c_city }}</td>
                                <td>{{ $contact->c_state }}</td>
                                <td>{{ $contact->c_phno }}</td>
                                <td>{{ $contact->c_email }}</td>
                                <td class="operation-icons">
                                    <a href="{{url('update-contact/'.$contact->id)}}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger delete-card-btn"
                                        data-url="{{url('delete-contact/'.$contact->id)}}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                            @php $incr++; @endphp
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
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-center">No contacts available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- DataTable Initialization Script -->
                <script>
                    $(document).ready(function() {
                        $('#contactTable').DataTable({
                            dom: '<"top"Bf>rt<"bottom"ip>',
                            buttons: [{
                                extend: 'csv',
                                text: 'Export', // Button label changed to "Export"
                                className: 'btn btn-outline-success'
                            }],
                            paging: true,
                            searching: true,
                            ordering: true,
                            lengthMenu: [10, 25, 50, 100],
                            pageLength: 10,
                            language: {
                                search: "Filter records:",
                                lengthMenu: "Show _MENU_ entries",
                                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                                paginate: {
                                    next: "<i class='fas fa-chevron-right'></i>", // Next icon
                                    previous: "<i class='fas fa-chevron-left'></i>" // Previous icon
                                }
                            },
                            // Hide the dummy row from display but keep it in the DOM
                            drawCallback: function() {
                                $('.d-none').hide();
                            }
                        });
                    });
                </script>

            </div>

            <!-- Search and Action Buttons -->
            <div class="tab-bg mb-4">
                <div class="d-flex justify-content-end gap-3">
                    <button class="btn btn-primary">Create New</button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
                </div>
            </div>


            <!-- Contact Information Form -->
            <div class="tab-bg">
                <form method="POST" action="{{url('add-contact')}}">
                    @csrf
                    <h2 class="fw-bold my-4">Contact Information</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Contact Type</label>
                            <select class="form-select" name="c_contact_type">
                                @foreach($contactTypes as $contactType)
                                <option value="{{$contactType->id}}">{{$contactType->contact_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" name="c_fname" value="{{old('c_fname', $updContact->c_fname ?? '')}}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="c_lname" value="{{old('c_lname', $updContact->c_lname ?? '')}}" class="form-control">
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
                            <select id="state" class="form-select" name="c_state" onchange="loadCities()">
                                <option value="">Select State</option>
                            </select>
                        </div>

                        <!-- City -->
                        <div class="col-md-4">
                            <select id="city" class="form-select" name="c_city" value="{{ $userMetaData->city ?? '' }}">
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-4">

                        <div class="col-md-4">
                            <label class="form-label">SMS/Mobile #</label>
                            <input type="number" name="c_phno" value="{{old('c_phno', $updContact->c_phno ?? '')}}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="c_email" value="{{old('c_email', $updContact->c_email ?? '')}}" class="form-control">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-3">

                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="clear" class="btn btn-secondary">Clear</button>

                    </div>
                </form>
            </div>

            <!-- <div class="tab-bg mt-4">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-danger">Failed Report</button>
                    <button class="btn btn-primary float-end" onclick="showScreen('screen2')">Next</button>
                </div>
            </div> -->


        </div>


        <!-- Screen 2 -->
        <div class="screen" id="screen2">
            <div class="container mt-4">
                <!-- Upload Section -->

                <div class="tab-bg my-4">
                    <div class="file-upload-section d-flex justify-content-between align-items-center">
                        <h5 class="text-muted">Upload Contact File</h5>
                        <button class="btn btn-danger delete-file">Delete file</button>
                    </div>

                    <!-- File Information -->
                    <div class="container p-0">
                        <p class="mt-3 file-info">
                            You have just uploaded the file <strong>“File XXXX.xls”</strong> with <strong>14</strong> lines and <strong>8</strong> columns.
                        </p>
                    </div>
                </div>

                <div class="tab-bg my-4">
                    <!-- Contact Data Table -->
                    <h5 class="mt-4">Contact Data</h5>
                    <div class="table-container">
                        <table class=" dataTable table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Field 1</th>
                                    <th>Field 2</th>
                                    <th>Field 3</th>
                                    <th>Field 4</th>
                                    <th>Field 5</th>
                                    <th>Field 6</th>
                                    <th>Field 7</th>
                                    <th>Field 8</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Value 1</td>
                                    <td>Value 2</td>
                                    <td>Value 3</td>
                                    <td>Value 4</td>
                                    <td>Value 5</td>
                                    <td>Value 6</td>
                                    <td>Value 7</td>
                                    <td>Value 8</td>
                                </tr>
                                <tr>
                                    <td>Value 1</td>
                                    <td>Value 2</td>
                                    <td>Value 3</td>
                                    <td>Value 4</td>
                                    <td>Value 5</td>
                                    <td>Value 6</td>
                                    <td>Value 7</td>
                                    <td>Value 8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-bg">
                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-dark px-4" onclick="showScreen('screen1')">Back</button>
                        <button class="btn btn-success px-4" onclick="showScreen('screen3')">Continue</button>
                    </div>
                </div>



            </div>
        </div>

        <!-- Screen 3 -->
        <div class="screen" id="screen3">
            <div class="container p-4">
                <div class="tab-bg">
                    <h5 class="text-muted">Upload Contact File</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted"><em><strong id="uploadedFileName">File XXXX.xls</strong></em> with <strong>14</strong> lines and <strong>8</strong> columns.</p>
                        <button class="btn btn-outline-dark px-4">Modify file</button>
                    </div>
                </div>

                <div class="tab-bg my-4">
                    <h5><strong>Mapping Data</strong></h5>
                    <div class="table-responsive border">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>FILE HEADER</th>
                                    <th>DATA</th>
                                    <th>COMPANY ATTRIBUTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Field 1</td>
                                    <td>Value 1</td>
                                    <td>
                                        <select class="form-select">
                                            <option selected>Do not import</option>
                                            <option>Attribute 1</option>
                                            <option>Attribute 2</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Field 2</td>
                                    <td>Value 2</td>
                                    <td>
                                        <select class="form-select">
                                            <option selected>Do not import</option>
                                            <option>Attribute 1</option>
                                            <option>Attribute 2</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-bg">
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-dark px-4" onclick="showScreen('screen2')">Back</button>
                        <button class="btn btn-success px-4" onclick="showScreen('screen4')">Continue</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Screen 4 -->
        <div class="screen" id="screen4">
            <div class="container border p-4">
                <!-- Upload Contact File -->
                <h5 class="text-muted">Upload Contact File</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted"><em><strong id="uploadedFileName">File XXXX.xls</strong></em> with <strong>14</strong> lines and <strong>8</strong> columns.</p>
                    <button class="btn btn-link text-dark">Modify file</button>
                </div>
                <hr>

                <!-- Mapping Data -->
                <h5 class="text-muted">Mapping Data</h5>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-link text-dark">Modify data mapping</button>
                </div>

                <!-- New Imported Contact List -->
                <h5><strong>New Imported Contact List</strong></h5>
                <div class="table-responsive border">
                    <table class=" dataTable table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Contact Type</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>SMS</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Business</td>
                                <td>Brown</td>
                                <td>Bradley</td>
                                <td>Minneapolis</td>
                                <td>MN</td>
                                <td>223 234-3456</td>
                                <td>BB312007@gmail.com</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Personal</td>
                                <td>Nancy</td>
                                <td>Smithindale</td>
                                <td>Chicago</td>
                                <td>IL</td>
                                <td>312 245-0980</td>
                                <td>nancywsmithinton@yh</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Contact Count -->
                <div class="text-center my-3">
                    <p class="fw-bold">Total Contact Ready To Import = 2 out of 14</p>
                </div>

                <!-- Confirm & Cancel Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <a class="btn btn-outline-dark px-4" href="#">I Confirm</a>
                    <button class="btn btn-outline-secondary px-4">Cancel</button>
                </div>
            </div>
            <button class="btn btn-secondary mt-3" onclick="showScreen('screen3')">Back</button>
            <button class="btn btn-success mt-3">Submit</button>
        </div>
    </div>


    <!-- modal boxes -->

    <!-- preview modal -->
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


    <!-- Bootstrap Modal for Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-4">
                <div class="modal-body">
                    <h5 class="mb-4">Upload Contact File</h5>

                    <form method="POST" action="{{url('import-contact-list')}}" enctype="multipart/form-data">
                        @csrf
                        <!-- File Upload Box -->
                        <label for="fileInput" class="border border-dark rounded p-5 text-center w-100 d-block" id="file-xl">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i> <!-- Larger Upload Icon -->
                            <p class="mb-1">Select your file or drop it here</p>
                            <small class="text-muted">Supported formats: .xls, .xlsx, .csv (Max: 250MB)</small>
                            <input type="file" name="file" id="fileInput" class="d-none" accept=".xls, .xlsx, .csv">
                        </label>



                        <!-- Submit and Download Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <!-- Download Template Button -->
                            <a href="{{ asset('/media/Contact-Template.csv') }}" download="Contact-Template.csv" class="btn btn-outline-dark">
                                <i class="fas fa-download me-2"></i> Download Template
                            </a>

                            <button type="submit" class="btn btn-primary" id="submitBtn" data-bs-dismiss="modal">
                                <i class="fas fa-check me-2"></i> Submit
                            </button>


                        </div>

                        <hr class="my-4">

                        <!-- Footer Buttons -->
                        <div class="d-flex justify-content-end gap-3">
                            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i> Cancel Import
                            </button>
                        </div>
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
    <!-- model box end -->



    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.colVis.min.js"></script>
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
            // Destroy existing DataTables before reinitializing
            $('.dataTable').each(function() {
                if ($.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable().destroy();
                }
            });

            // Initialize DataTables with .dataTable class
            $('.dataTable').DataTable({
                dom: '<"top"Bf>rt<"bottom"ip>',
                buttons: [{
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> Export', // Label changed to "Export"
                    className: 'btn btn-outline-success'
                }],
                paging: true,
                searching: true,
                ordering: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                language: {
                    search: "Filter records:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        next: "<i class='fas fa-chevron-right'></i>", // Next icon
                        previous: "<i class='fas fa-chevron-left'></i>" // Previous icon
                    }
                },
                drawCallback: function() {
                    $('.d-none').hide(); // Hide the dummy row on each draw
                }
            });
        });


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

        // Open Import Popup
        document.getElementById("importButton").addEventListener("click", function() {
            document.getElementById("importPopup").style.display = "block";
        });

        // Close Popup & Redirect on Continue Button
        document.getElementById("continueButton").addEventListener("click", function() {
            document.getElementById("importPopup").style.display = "none";
            window.location.href = "screen-2.html"; // Change this to your actual screen-2 URL
        });

        // File Upload Functionality
        document.getElementById("uploadBox").addEventListener("click", function() {
            document.getElementById("fileInput").click();
        });

        document.getElementById("uploadBox").addEventListener("dragover", function(event) {
            event.preventDefault();
            this.style.backgroundColor = "#f1f1f1";
        });

        document.getElementById("uploadBox").addEventListener("dragleave", function() {
            this.style.backgroundColor = "white";
        });

        document.getElementById("uploadBox").addEventListener("drop", function(event) {
            event.preventDefault();
            this.style.backgroundColor = "white";
            const files = event.dataTransfer.files;
            document.getElementById("fileInput").files = files;
        });

        function showScreen(screenId) {

            // Hide all screens
            document.querySelectorAll('.screen').forEach(screen => {
                screen.classList.remove('active');
            });

            // Show the selected screen
            document.getElementById(screenId).classList.add('active');
        }
    </script>

    @stop