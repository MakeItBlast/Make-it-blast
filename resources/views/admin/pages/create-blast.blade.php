@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/create-blast.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


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
    <form>
        @csrf


        <div class="screens">
            <!-- screen 1 -->
            <div class="screen active" id="screen-1">
                <div class="container">
                    <div class="head d-flex justify-content-between mb-3">
                        <h2 class="mb-3">New Blast Form</h2>
                        <h5>Step 1</h5>
                    </div>
                    <div class="tab-bg mt-4 mb-4">
                        <!-- Message Type Selection -->
                        <div class="mb-3">
                            <div class="msg d-flex justify-content-center g-3">

                                <div class="idmsg">
                                    <input type="checkbox" id="smsMessage">
                                    <label for="smsMessage">SMS Message</label>
                                </div>

                                <div class="idmsg">
                                    <input type="checkbox" id="emailMessage" class="ms-3">
                                    <label for="emailMessage">Email Message</label>
                                </div>

                                <div class="idmsg">
                                    <input type="checkbox" id="digitalMedia" class="ms-3">
                                    <label for="digitalMedia">Digital Media</label>
                                </div>




                            </div>
                        </div>

                        <!-- Blast Name and Contact Type Selection -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="blastName" class="form-label">Blast Name</label>
                                <input type="text" class="form-control" id="blastName">
                            </div>
                            <div class="col-md-6">
                                <label for="contactType" class="form-label">Contact Type</label>
                                <div class="d-flex">
                                    <select class="form-select" id="contactType">
                                        <option selected>Choose...</option>
                                        <option value="1">Personal</option>
                                        <option value="2">Business</option>
                                    </select>
                                    <button class="btn btn-danger ms-2">Add to List</button>
                                </div>
                            </div>
                        </div>

                        <!-- All Contact Checkbox -->
                        <div class="cnc-type">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="allContact">
                                <label class="form-check-label" for="allContact">
                                    All Contact
                                </label>
                            </div>

                            <!-- Contact Type Selected -->
                            <div class="mb-3">
                                <label class="form-label">Contact Type Selected</label>
                                <div class="border p-2" style="height: 100px; overflow-y: auto;">
                                    <ul class="list-unstyled mb-0">
                                        <li>Personal</li>
                                        <li>Business</li>
                                        <li>Business</li>
                                        <li>Business</li>
                                        <li>Business</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-bg mt-4 mb-4">
                        <!-- Blast Contact List Table -->
                        <h5 class="mt-4">Blast Contact List</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Contact Type</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>TimeZone</th>
                                        <th>SMS/Mobile</th>
                                        <th>Email</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Personal</td>
                                        <td>Jane</td>
                                        <td>Smith</td>
                                        <td>Jackson</td>
                                        <td>MS</td>
                                        <td>Central</td>
                                        <td>(601) 445-2098</td>
                                        <td>Jsmithat@mitail.com</td>
                                        <td class="operation-icons">
                                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Personal</td>
                                        <td>Walter</td>
                                        <td>Walker</td>
                                        <td>Road Island</td>
                                        <td>BM</td>
                                        <td>Eastern</td>
                                        <td>(312) 243-5630</td>
                                        <td>Wwalker@msn.com</td>
                                        <td class="operation-icons">
                                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Business</td>
                                        <td>Harold</td>
                                        <td>Washington</td>
                                        <td>Jacksonville</td>
                                        <td>OH</td>
                                        <td>Western</td>
                                        <td>(901) 837-9003</td>
                                        <td>-</td>
                                        <td class="operation-icons">
                                            <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Total Contacts for Blast -->
                        <p class="text-end fw-bold">Total Contacts for Blast: 3</p>

                        <!-- Credits Section -->
                        <div class="credits-section text-center custom-border py-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <p>Credits Available<br><strong>500</strong></p>
                                <p>Current Used<br><strong>18</strong></p>
                                <p>Remaining Credits<br><strong>482</strong></p>
                                <button class="btn btn-outline-dark b-cred">Buy Credits</button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary next-btn" data-target="#screen-2">Next</button>
                    </div>


                </div>

            </div>

            <!-- Screen 2 -->
            <div class="screen" id="screen-2">

                <div class="head d-flex justify-content-between mb-3">
                    <h2 class="mb-3">(Blast Name) Message Editor</h2>
                    <h5>Step 2</h5>
                </div>
                <form>
                    <div class="tab-bg">

                        <div class="container">
                            <div class="head mb-3">
                                <h2 class="mb-3">NEW BLAST FORM</h2>
                                <h5>Step 2</h5>

                                <!-- Add Editor Section -->
                                <label for="messageEditor" class="form-label"><strong>(BLAST NAME)</strong> Message Editor</label>
                                <div id="summernote"></div>
                            </div>

                            <!-- Buttons Below Editor -->
                            <div class="d-flex flex-wrap mt-3 gap-2">
                                <select id="templateSelect" class="form-select w-auto">
                                    <option value="" selected>Select Template</option>
                                    <option value="template1">Template 1</option>
                                    <option value="template2">Template 2</option>
                                </select>
                                <button id="aiMyBlast" class="btn btn-danger">AI MY BLAST</button>
                                <button id="saveTemplate" class="btn btn-secondary">Save as Template</button>
                                <button id="undoAction" class="btn btn-dark">Undo</button>
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-2">
                        <button type="button" class="btn btn-secondary back-btn" data-target="#screen-1">Back</button>
                        <button type="button" class="btn btn-primary next-btn" data-target="#screen-3">Next</button>
                    </div>

                </form>
            </div>

            <!-- Screen 3 -->
            <div class="screen" id="screen-3">
                <div class="container">
                    <div class="head d-flex justify-content-between mb-3">
                        <h2 class="mb-3">New Blast Form</h2>
                        <h5>Step 3</h5>
                    </div>

                    <div class="tab-bg mt-4 mb-4">
                        <h5 class="mb-3">(BLAST NAME) Additional Options</h5>

                        <!-- Include Yes or No Answer -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="includeAnswer">
                            <label class="form-check-label text-danger" for="includeAnswer">
                                Include (Yes or No) Answer
                            </label>
                        </div>

                        <!-- Input Question -->
                        <div class="mb-3">
                            <label for="inputQuestion" class="form-label">Input Question:</label>
                            <input type="text" class="form-control" id="inputQuestion">
                        </div>

                        <!-- Before and After Message -->
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" id="beforeMessage">
                            <label class="form-check-label me-3" for="beforeMessage">
                                Before Message
                            </label>

                            <input class="form-check-input" type="checkbox" id="afterMessage">
                            <label class="form-check-label" for="afterMessage">
                                After Message
                            </label>
                        </div>

                        <!-- Add Keywords and Keywords List -->
                        <div class="row g-3 mb-3">
                            <!-- Add Keywords -->
                            <div class="col-md-6">
                                <label for="addKeywords" class="form-label">Add Keywords</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control" id="addKeywords">
                                    <button class="btn btn-danger ms-2" id="addKeywordBtn">Add to List</button>
                                </div>
                            </div>

                            <!-- Keywords List -->
                            <div class="col-md-6">
                                <label class="form-label">Key Words List</label>
                                <select class="form-select" id="keywordsList" size="4">
                                    <option>Business</option>
                                    <option>Personal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Preview Button -->
                        <div class="text-center mb-3">
                            <button class="btn btn-outline-dark">PREVIEW</button>
                        </div>

                        <!-- Credits Section -->
                        <div class="credits-section text-center custom-border py-3">
                            <div class="d-flex justify-content-between">
                                <p>Credits Available<br><strong>500</strong></p>
                                <p>Current Used<br><strong>18</strong></p>
                                <p>Remaining Credits<br><strong>482</strong></p>
                                <button class="btn btn-outline-dark b-cred">Buy Credits</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-center gap-3 mt-2">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-2">Back</button>
                    <button type="button" class="btn btn-primary next-btn" data-target="#screen-4">Next</button>
                </div>

            </div>

            <!-- Screen 4  -->
            <div class="screen" id="screen-4">
                <div class="head d-flex justify-content-between mb-3">
                    <h2 class="mb-3">New Blast Form</h2>
                    <h5>Step 4</h5>
                </div>
                <h5 class="mt-3">(Blast Name) Schedule</h5>
                <div class="container mt-4">

                    <div class="tab-bg mt-4 mb-4">
                        <div class="row g-3 mb-3">
                            <!-- Date Picker -->
                            <div class="col-md-3">
                                <label for="blastDate" class="form-label">Blast Date</label>
                                <input type="text" class="form-control" id="blastDate" placeholder="Select Date">
                            </div>

                            <!-- Time Picker -->
                            <div class="col-md-3">
                                <label for="blastTime" class="form-label">Blast Time</label>
                                <input type="text" class="form-control" id="blastTime" placeholder="Select Time">
                            </div>

                            <!-- Time Zone Picker -->
                            <div class="col-md-3">
                                <label for="timeZone" class="form-label">Time Zone</label>
                                <select class="form-select" id="timeZone">
                                    <option selected>Select Time Zone</option>
                                </select>
                            </div>

                            <!-- Add to List Button -->
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-outline-dark w-100">Add to List</button>
                            </div>
                        </div>
                    </div>


                    <div class="tab-bg mt-4 mb-4">
                        <div class="mb-3">
                            <h5>Scheduled Dates</h5>
                            <div class="border p-2">
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between align-items-center mb-2">
                                        12/24/2024 – 12:35 PM CST
                                        <button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center mb-2">
                                        12/26/2024 – 1:30 PM CST
                                        <button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <p class="mt-2">Blast Total = 2</p>
                        </div>

                        <div class="credits-info">
                            <div class="d-flex justify-content-between">
                                <p>Credits Available <br><span class="fw-bold">500</span></p>
                                <p>Current Used <br><span class="fw-bold">18</span></p>
                                <p>Remaining Credits <br><span class="fw-bold">482</span></p>
                                <button class="btn btn-outline-dark b-cred">Buy Credits</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-2">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-3">Back</button>
                    <button type="button" class="btn btn-primary next-btn" data-target="#screen-5">Next</button>
                </div>
            </div>

            <!-- Screen 5 -->
            <div class="screen" id="screen-5">
                <div class="head d-flex justify-content-between mb-3">
                    <h2 class="mb-3">Blast Invoice</h2>
                    <h5>Step 5</h5>
                </div>
                <div class="tab-bg mt-4 mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Service Description</th>
                                    <th>Credit Cost</th>
                                    <th>Quantity</th>
                                    <th>Total Credits</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>SMS Contact Count</td>
                                    <td>405</td>
                                    <td>2</td>
                                    <td>810</td>
                                    <td class="operation-icons">
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Image Cost</td>
                                    <td>20</td>
                                    <td>2</td>
                                    <td>40</td>
                                    <td class="operation-icons">
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>AI Integration</td>
                                    <td>100</td>
                                    <td>1</td>
                                    <td>100</td>
                                    <td class="operation-icons">
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="credits-info">
                        <div class="d-flex gap-5 justify-content-center mb-3 mt-3">
                            <p>Credits Available <span class="fw-bold">500</span></p>
                            <p>Remaining Credits <span class="fw-bold">482</span></p>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-5 justify-content-center mb-3 mt-3">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-4">Back</button>
                    <button type="button" class="btn btn-success">Process</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
</div>


</form>


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

<!-- Bootstrap Modal for Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-body">
                <h5 class="mb-3">Upload Contact File</h5>

                <!-- File Upload Box -->
                <label for="fileInput" class="border border-dark rounded p-4 text-center w-100 d-block" id="file-xl">
                    <i class="fas fa-cloud-upload-alt fa-2x"></i> <!-- Font Awesome Upload Icon -->
                    <p class="mb-0">Select your file or drop it here</p>
                    <small class="text-muted">Up to 250MB</small>
                    <input type="file" id="fileInput" class="d-none" accept=".xls, .xlsx, .csv">
                </label>

                <!-- Additional Information -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted small mb-0 w-50">We do not sell, rent or use your data for any commercial purposes.
                        <a href="#">Learn more</a> about our data policy.
                    </p>

                    <!-- Download Template Button -->
                    <button class="btn btn-outline-dark">Download Template</button>
                </div>

                <hr>

                <!-- Footer Buttons -->
                <div class="d-flex justify-content-end">
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel Import</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // Script for multiple screens in on tab 
    const nextButtons = document.querySelectorAll('.next-btn');
    const backButtons = document.querySelectorAll('.back-btn');
    let currentScreen = document.querySelector('.screen.active');

    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetScreenId = this.getAttribute('data-target');
            const targetScreen = document.querySelector(targetScreenId);

            if (targetScreen !== currentScreen) {
                // Start fade-out animation for the current screen
                currentScreen.classList.add('fade-out');

                // Wait for the fade-out animation to finish
                setTimeout(() => {
                    // Hide the current screen
                    currentScreen.classList.remove('active', 'fade-out');
                    currentScreen.style.display = 'none';

                    // Show and fade-in the next screen
                    targetScreen.style.display = 'block';
                    targetScreen.classList.add('active', 'fade-in');

                    // Clean up classes after animation ends
                    setTimeout(() => {
                        targetScreen.classList.remove('fade-in');
                        currentScreen = targetScreen;
                    }, 500);
                }, 500); // Matches the animation duration
            }
        });
    });

    backButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetScreenId = this.getAttribute('data-target');
            const targetScreen = document.querySelector(targetScreenId);

            if (targetScreen !== currentScreen) {
                // Start fade-out animation for the current screen
                currentScreen.classList.add('fade-out');

                // Wait for the fade-out animation to finish
                setTimeout(() => {
                    // Hide the current screen
                    currentScreen.classList.remove('active', 'fade-out');
                    currentScreen.style.display = 'none';

                    // Show and fade-in the previous screen
                    targetScreen.style.display = 'block';
                    targetScreen.classList.add('active', 'fade-in');

                    // Clean up classes after animation ends
                    setTimeout(() => {
                        targetScreen.classList.remove('fade-in');
                        currentScreen = targetScreen;
                    }, 500);
                }, 500); // Matches the animation duration
            }
        });
    });
</script>

<script>
    // for adding keywords in list 
    document.getElementById("addKeywordBtn").addEventListener("click", function() {
        var keywordInput = document.getElementById("addKeywords");
        var keywordValue = keywordInput.value.trim();

        // Check if input is not empty
        if (keywordValue) {
            var keywordsList = document.getElementById("keywordsList");

            // Create a new option element
            var newOption = document.createElement("option");
            newOption.text = keywordValue;

            // Add the new option to the list
            keywordsList.add(newOption);

            // Clear the input field
            keywordInput.value = "";
        } else {
            alert("Please enter a keyword.");
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.43/builds/moment-timezone-with-data.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        // Initialize Date Picker
        flatpickr("#blastDate", {
            dateFormat: "Y-m-d",
            minDate: "today" // Disable past dates
        });

        // Initialize Time Picker
        flatpickr("#blastTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            time_24hr: false // 12-hour format with AM/PM
        });

        // Populate Time Zones in GMT format
        const timeZoneSelect = document.getElementById("timeZone");
        const timeZones = moment.tz.names();

        if (timeZoneSelect) {
            timeZones.forEach(tz => {
                const offset = moment.tz(tz).format('Z');
                const option = document.createElement("option");
                option.value = tz;
                option.textContent = `GMT${offset} (${tz})`;
                timeZoneSelect.appendChild(option);
            });
        }
    });


    // for summernote editor and modifications

    $(document).ready(function() {
        // Define Custom Button for Data Field (Dropdown)
        var dataFieldButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.buttonGroup([
                ui.button({
                    className: 'dropdown-toggle',
                    contents: '<i class="fa fa-database"/> Data Field <span class="caret"></span>',
                    tooltip: 'Insert Data Field',
                    data: {
                        toggle: 'dropdown'
                    }
                }),
                ui.dropdown({
                    className: 'dropdown-menu',
                    contents: `
                       
                            <a class="dropdown-item" href="#" data-value="[First]">First Name</a>
                            <a class="dropdown-item" href="#" data-value="[Last]">Last Name</a>
                            <a class="dropdown-item" href="#" data-value="[Email]">Email</a>
                            <a class="dropdown-item" href="#" data-value="[Phone]">Phone Number</a>
                        `,
                    callback: function($dropdown) {
                        $dropdown.find('.dropdown-item').each(function() {
                            $(this).click(function(e) {
                                e.preventDefault();
                                var selectedField = $(this).data('value');
                                context.invoke('editor.insertText', selectedField);
                            });
                        });
                    }
                })
            ]);
            return button.render();
        };

        // Define Custom Button for Add Image (File Upload)
        var addImageButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="fa fa-upload"/> Add Image',
                tooltip: 'Insert Image from File',
                click: function() {
                    $('<input type="file" accept="image/*">').on('change', function() {
                        var file = this.files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                context.invoke('editor.insertImage', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    }).click();
                }
            });
            return button.render();
        };

        // Define Custom Button for Add Link
        var addLinkButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="fa fa-link"/> Add Link',
                tooltip: 'Insert Hyperlink',
                click: function() {
                    var linkUrl = prompt('Enter Link URL:');
                    var linkText = prompt('Enter Link Text:');
                    if (linkUrl && linkText) {
                        var linkHtml = `<a href="${linkUrl}" target="_blank">${linkText}</a>`;
                        context.invoke('editor.pasteHTML', linkHtml);
                    }
                }
            });
            return button.render();
        };

        // Initialize Summernote with Custom Toolbar
        $('#summernote').summernote({
            height: 300,
            placeholder: 'Write your message here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['mybutton', ['dataField', 'addImage', 'addLink']] // Custom Buttons
            ],
            buttons: {
                dataField: dataFieldButton,
                addImage: addImageButton,
                addLink: addLinkButton
            }
        });

        // Select Template Button Functionality
        $('#templateSelect').change(function() {
            var selectedTemplate = $(this).val();
            if (selectedTemplate === 'template1') {
                $('#summernote').summernote('code', '<p>Hello [[First]] [[Last]],</p><p>I want to tell you about my event!</p>');
            } else if (selectedTemplate === 'template2') {
                $('#summernote').summernote('code', '<p>Dear Customer,</p><p>Thank you for your interest in our event.</p>');
            }
        });

        // AI MY BLAST Button Functionality
        $('#aiMyBlast').click(function() {
            var content = $('#summernote').summernote('code');
            alert('AI is modifying your content... (API Integration Pending)');
            // Replace with an API call for AI-modified content
        });

        // Save as Template Button Functionality
        $('#saveTemplate').click(function() {
            var content = $('#summernote').summernote('code');
            alert('Template saved successfully!');
            console.log('Saved Template Content:', content);
        });

        // Undo Button Functionality
        $('#undoAction').click(function() {
            $('#summernote').summernote('undo');
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
</script>





@stop