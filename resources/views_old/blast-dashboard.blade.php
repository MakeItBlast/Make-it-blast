@include('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('styles/blast-dash.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

<body>
    <div class="container mt-5">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">
                    MY DASHBOARD
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="create-blast-tab" data-bs-toggle="tab" data-bs-target="#create-blast" type="button" role="tab" aria-controls="create-blast" aria-selected="false">
                    Create A Blast
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manage-blasts-tab" data-bs-toggle="tab" data-bs-target="#manage-blasts" type="button" role="tab" aria-controls="manage-blasts" aria-selected="false">
                    Manage My Blasts
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing" type="button" role="tab" aria-controls="billing" aria-selected="false">
                    Billing and Payments
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- MY DASHBOARD Tab -->
            <div class="tab-pane fade show active mb-5 border p-4" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <!-- My Active Subscriptions -->
                <h3>My Active Subscriptions</h3>
                <div class="table-responsive" style="max-height: 175px; overflow-y: auto;">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Subscription Name</th>
                                <th>Credit Card Number</th>
                                <th>Expiration Date</th>
                                <th>Last Processed</th>
                                <th>Days Remaining</th>
                                <th>Account Status</th>
                                <th>Credits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Premium</td>
                                <td>XXXX-XXXX-XXXX-2453</td>
                                <td>1/23/2026</td>
                                <td>12/23/2025</td>
                                <td>Active</td>
                                <td>Active</td>
                                <td>500</td>
                            </tr>
                            <tr>
                                <td>Premium</td>
                                <td>XXXX-XXXX-XXXX-2453</td>
                                <td>1/23/2026</td>
                                <td>12/23/2025</td>
                                <td>Active</td>
                                <td>Active</td>
                                <td>500</td>
                            </tr>
                            <tr>
                                <td>Premium</td>
                                <td>XXXX-XXXX-XXXX-2453</td>
                                <td>1/23/2026</td>
                                <td>12/23/2025</td>
                                <td>Active</td>
                                <td>Active</td>
                                <td>500</td>
                            </tr>

                            <tr>
                                <td>Premium</td>
                                <td>XXXX-XXXX-XXXX-2453</td>
                                <td>1/23/2026</td>
                                <td>12/23/2025</td>
                                <td>Active</td>
                                <td>Active</td>
                                <td>500</td>
                            </tr>

                            <tr>
                                <td>Premium</td>
                                <td>XXXX-XXXX-XXXX-2453</td>
                                <td>1/23/2026</td>
                                <td>12/23/2025</td>
                                <td>Active</td>
                                <td>Active</td>
                                <td>500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Apply Coupon and Credits Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <button class="btn btn-outline-primary">Apply Coupon</button>
                        <input type="text" class="form-control d-inline-block w-auto" placeholder="Enter Coupon">
                    </div>
                    <div>
                        <a href="{{ url('profile?tab=subscription')}}" class="btn btn-outline-success">
                            Buy More Credits
                        </a>
                        <span class="ms-2">Total Available Credits: <strong>456</strong></span>
                    </div>
                </div>

                <!-- My Blasts Section -->
                <h3>My Blasts</h3>
                <p>
                    <span class="text-success">In Progress</span> |
                    <span class="text-danger">Need Payment</span> |
                    <span class="text-secondary">Completed</span>
                    <a href="#" class="float-end text-primary">Show All</a>
                </p>

                <!-- My Blasts Table -->
                <div class="table-responsive" style="max-height: 175px; overflow-y: auto;">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Blast Name</th>
                                <th>Recipients</th>
                                <th>Blasts</th>
                                <th>Completed</th>
                                <th>Start Date</th>
                                <th>End State</th>
                                <th>Cost</th>
                                <th>Success</th>
                                <th>Failed</th>
                                <th>Replies</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-success">Winter Rose Peeps</td>
                                <td class="text-success">1,203</td>
                                <td>10</td>
                                <td>2</td>
                                <td>12/14/2024</td>
                                <td>12/24/2024</td>
                                <td class="text-success">$255.00</td>
                                <td class="text-success">2,406</td>
                                <td>0</td>
                                <td>423</td>
                                <td><button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button></td>
                            </tr>
                            <tr>
                                <td class="text-danger">Micheal Birthday Party</td>
                                <td class="text-danger">31,080</td>
                                <td>5</td>
                                <td>0</td>
                                <td>12/24/2024</td>
                                <td>12/24/2024</td>
                                <td class="text-danger">$435.00</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="operation-icons">
                                    <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>B Cole Comedy Show</td>
                                <td>400</td>
                                <td>2</td>
                                <td>2</td>
                                <td>11/14/2024</td>
                                <td>11/24/2024</td>
                                <td>$255.00</td>
                                <td>784</td>
                                <td>16</td>
                                <td>521</td>
                                <td><button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button></td>
                            </tr>

                            <tr>
                                <td>B Cole Comedy Show</td>
                                <td>400</td>
                                <td>2</td>
                                <td>2</td>
                                <td>11/14/2024</td>
                                <td>11/24/2024</td>
                                <td>$255.00</td>
                                <td>784</td>
                                <td>16</td>
                                <td>521</td>
                                <td><button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button></td>
                            </tr>

                            <tr>
                                <td>B Cole Comedy Show</td>
                                <td>400</td>
                                <td>2</td>
                                <td>2</td>
                                <td>11/14/2024</td>
                                <td>11/24/2024</td>
                                <td>$255.00</td>
                                <td>784</td>
                                <td>16</td>
                                <td>521</td>
                                <td><button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Search and Footer Summary -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="input-group w-25">
                        <input type="text" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-primary">Go</button>
                    </div>
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


            <!-- Create A Blast Tab with Multi-Screen Form -->
            <div class="tab-pane fade mb-5 border p-4" id="create-blast" role="tabpanel" aria-labelledby="create-blast-tab">
                <!-- Screen 1 -->
                <div class="screen active" id="screen-1">
                    <div class="container">
                        <div class="head mb-3">
                            <h2 class="mb-3">New Blast Form</h2>
                            <h5>Step 1</h5>
                        </div>


                        <!-- Message Type Selection -->
                        <div class="mb-3">
                            <div class="msg">

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

                        <!-- Navigation Buttons -->
                        <div class="d-flex">
                            <button type="button" class="btn btn-primary next-btn" data-target="#screen-2">Next</button>
                        </div>


                    </div>

                </div>

                <!-- Screen 2 -->
                <div class="screen" id="screen-2">

                    <div class="head mb-3">
                        <h2 class="mb-3">(Blast Name) Message Editor</h2>
                        <h5>Step 2</h5>
                    </div>
                    <form>
                        <div class="mb-3">
                            <label for="audience" class="form-label">Target Audience:</label>
                            <input type="text" class="form-control" id="audience" placeholder="Enter target audience">
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <button type="button" class="btn btn-secondary back-btn" data-target="#screen-1">Back</button>
                            <button type="button" class="btn btn-primary next-btn" data-target="#screen-3">Next</button>
                        </div>

                    </form>
                </div>

                <!-- New Screen 3 -->
                <div class="screen" id="screen-3">
                    <div class="container">
                        <div class="head mb-3">
                            <h2 class="mb-3">New Blast Form</h2>
                            <h5>Step 3</h5>
                        </div>
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

                    <div class="d-flex justify-content-center gap-3 mt-2">
                        <button type="button" class="btn btn-secondary back-btn" data-target="#screen-2">Back</button>
                        <button type="button" class="btn btn-primary next-btn" data-target="#screen-4">Next</button>
                    </div>

                </div>

                <!-- Screen 4 (previously Screen 3) -->
                <div class="screen" id="screen-4">
                    <div class="head mb-3">
                        <h2 class="mb-3">New Blast Form</h2>
                        <h5>Step 4</h5>
                    </div>
                    <h5 class="mt-3">(Blast Name) Schedule</h5>
                    <div class="container mt-4">

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
                    <div class="d-flex justify-content-center gap-3 mt-2">
                        <button type="button" class="btn btn-secondary back-btn" data-target="#screen-3">Back</button>
                        <button type="button" class="btn btn-primary next-btn" data-target="#screen-5">Next</button>
                    </div>
                </div>

                <div class="screen" id="screen-5">
                    <div class="head mb-3">
                        <h2 class="mb-3">Blast Invoice</h2>
                        <h5>Step 5</h5>
                    </div>
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
                    <div class="d-flex gap-5 justify-content-center mb-3 mt-3">
                        <button type="button" class="btn btn-secondary back-btn" data-target="#screen-4">Back</button>
                        <button type="button" class="btn btn-success">Process</button>
                        <button type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>

            <!-- Manage My Blasts Tab -->
            <div class="tab-pane mb-5 border p-4" id="manage-blasts" role="tabpanel" aria-labelledby="manage-blasts-tab">
                <div class="container mt-4">
                    <h2>Hello</h2>
            </div>
            </div>
        </div>
    </div>

            <!-- Popup Boxes -->

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

            <!-- Import Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content p-4">
                        <h5 class="modal-title">Upload Contact File</h5>
                        <div class="d-flex justify-content-between align-items-start">
                            <!-- File Upload Box -->
                            <div class="upload-box w-50" id="uploadBox">
                                <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                <p>Select your file or drop it here<br>Up to 250MB</p>
                                <input type="file" id="fileInput" accept=".csv, .xls, .xlsx">
                            </div>

                            <p class="w-50 ms-3">
                                We do not sell, rent, or use your data for any commercial purposes.
                                Learn more about our data policy.
                            </p>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-outline-secondary">Download Template</button>
                            <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel Import</button>
                        </div>
                        <hr>
                        <p class="text-muted">Mapping Data</p>
                        <div class="text-center">
                            <button class="btn btn-primary" data-bs-dismiss="modal">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
            <script>
                // Function to display file name
                function displayFileName() {
                    var input = document.getElementById('imageUpload');
                    var fileName = document.getElementById('fileName');
                    var removeButton = document.getElementById('removeButton');
                    if (input.files.length > 0) {
                        fileName.textContent = input.files[0].name;
                        removeButton.style.display = 'inline-block';
                    } else {
                        fileName.textContent = 'No file chosen';
                        removeButton.style.display = 'none';
                    }
                }

                // Function to remove selected file
                function removeFile() {
                    var input = document.getElementById('imageUpload');
                    input.value = "";
                    displayFileName();
                }

                // Listen for when a tab is shown
                document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function(tab) {
                    tab.addEventListener('shown.bs.tab', function(event) {
                        // Get the newly active tab content
                        var target = document.querySelector(event.target.getAttribute('data-bs-target'));

                        // Remove animation class from all tab panes
                        document.querySelectorAll('.tab-pane').forEach(function(pane) {
                            pane.classList.remove('slide-in');
                        });

                        // Add the slide-in class to the active tab content
                        target.classList.add('slide-in');

                        // Update the URL with the active tab ID
                        const tabId = event.target.getAttribute('data-bs-target').replace('#', '');
                        const newUrl = window.location.pathname + '?tab=' + tabId;
                        history.pushState(null, null, newUrl);
                    });
                });

                // On page load, check if there's a tab in the URL and activate it
                document.addEventListener("DOMContentLoaded", function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const activeTab = urlParams.get('tab');

                    if (activeTab) {
                        const tabButton = document.querySelector(`button[data-bs-target="#${activeTab}"]`);
                        if (tabButton) {
                            new bootstrap.Tab(tabButton).show();
                        }
                    }
                });

                $(document).ready(function() {
                    // Character count update logic
                    $('.editor-area').on('input', function() {
                        var text = $(this).text();
                        var charCount = text.length;
                        $('#char-count').text(charCount);
                    });
                });
            </script>

            <!-- Include Summernote CSS -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">

            <!-- Include Summernote JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
            <!-- JS Libraries -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.43/builds/moment-timezone-with-data.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote({
                        placeholder: 'Write your message here...',
                        tabsize: 2,
                        height: 300,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ]
                    });
                });
            </script>
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

            <script>
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

                timeZones.forEach(tz => {
                    const offset = moment.tz(tz).format('Z');
                    const option = document.createElement("option");
                    option.value = tz;
                    option.textContent = `GMT${offset}`;
                    timeZoneSelect.appendChild(option);
                });
            </script>

            <script>
                // for inner tabs
                function nextStep(step) {
                    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
                    document.getElementById('step' + step).classList.add('active');
                }

                function prevStep(step) {
                    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
                    document.getElementById('step' + step).classList.add('active');
                }
            </script>

            <script>
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
            </script>
</body>