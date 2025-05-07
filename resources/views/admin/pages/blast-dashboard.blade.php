
@extends('admin.layout.app')

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
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">
                    <span><i class="fa-solid fa-address-card"></i>My Dashboard</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="create-blast-tab" data-bs-toggle="tab" data-bs-target="#create-blast" type="button" role="tab" aria-controls="create-blast" aria-selected="false">
                    <span><i class="fa-solid fa-folder-plus"></i>Create A Blast</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manage-blasts-tab" data-bs-toggle="tab" data-bs-target="#manage-blasts" type="button" role="tab" aria-controls="manage-blasts" aria-selected="false">
                    <span><i class="fa-solid fa-list-check"></i>Manage My Blasts</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing" type="button" role="tab" aria-controls="billing" aria-selected="false">
                    <span><i class="fa-solid fa-file-invoice-dollar"></i>Billing And Payments</span>
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
                        <a href="/profile?tab=subscription" class="btn btn-outline-success">
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
                    <!--adding editor-->


<form method="post">
  <textarea id="summernote" name="editordata"></textarea>
</form>
<script>
    $(document).ready(function() {
  $('#summernote').summernote();
});
</script>
                    <form>
                       <input type="submit" value="Add Image">
                    </form>
                    
                    <form>
                       <input type="submit" value="Add Link">
                    </form>
                    
                    <form>
                       <input type="submit" value="AI my Blast">
                    </form>
                    
                    <form>
                       <input type="submit" value="Save as Tempelate">
                    </form>
                    
                    <form>
                       <input type="submit" name="Undo">
                    </form>
                    Data Field
                    <select>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>

                    Select Tempelate
                    <select>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>


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
                    <h3 class="fw-bold">Contact Type</h3>

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" id="cont-tab">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#contact-type">Contact Type</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#my-contacts">My Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#my-network">My Network</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#my-templates">My Templates</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3">
                        <!-- Contact Type Tab -->
                        <div class="tab-pane fade show active" id="contact-type">
                            <h5 class="fw-bold">Contact Type List</h5>
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type ID</th>
                                        <th>Contact Type</th>
                                        <th>Type Description</th>
                                        <th>Enabled</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Business</td>
                                        <td>Individual of Service and Financial Connection</td>
                                        <td>Yes</td>
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
                                        <td>2</td>
                                        <td>Personal</td>
                                        <td>Individual of Family and Friend Connection</td>
                                        <td>Yes</td>
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
                                        <td>2</td>
                                        <td>Personal</td>
                                        <td>Individual of Family and Friend Connection</td>
                                        <td>Yes</td>
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
                            
                            <p class="text-end"><strong>Total = 2</strong></p>

                            <!-- Search Bar -->
                            <div class="mb-3 d-flex">
                                <input type="text" class="form-control w-25" placeholder="Search...">
                                <button class="btn btn-primary ms-2">Go</button>
                            </div>

                            <!-- Add Contact Type Form -->
                            <h6 class="fw-bold">Add Contact Type</h6>
                            <form method="POST" action="{{ url('store-contact-type') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Contact Type</label>
                                    <input type="text" class="form-control" name="contact_type" value="{{ old('contact_type') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="contact_desc">{{ old('contact_desc') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Enabled</label>
                                    <input type="checkbox" name="status" value="active" {{ old('status') == 'active' ? 'checked' : '' }}>
                                    <span>Active</span>
                                </div>
                                <div class="mb-3">
                                    <input type="reset" name="CLEAR" class="btn btn-secondary">
                                    <input type="submit" name="SAVE" class="btn btn-success">
                                </div>
                            </form>


                        <!-- My Contacts Tab - Multi-Screen Layout -->
                        <div class="tab-pane fade" id="my-contacts">
                            <h5 class="fw-bold">My Contacts</h5>

                            <div id="multiScreenContainer">
                                <!-- Screen 1 - Matches Provided Layout -->
                                <div class="screen active" id="screen1">
                                    <h6 class="fw-bold">Contact List</h6>
                                    <div class="table-responsive">
                                    <table>
                                        <thead class="table-light">
                                            <tr>
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
                                            <tr>
                                                <td>Business</td>
                                                <td>Brown</td>
                                                <td>Bradley</td>
                                                <td>Minneapolis</td>
                                                <td>MN</td>
                                                <td>223 234-3456</td>
                                                <td>BB312007@gmail.com</td>
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
                                                <td>Smithindale</td>
                                                <td>Nancy</td>
                                                <td>Chicago</td>
                                                <td>IL</td>
                                                <td>312 245-0980</td>
                                                <td>nancywsmithinton@yh</td>
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
                                    

                                    <!-- Search and Action Buttons -->
                                    <div class="d-flex mb-3">
                                        <input type="text" class="form-control w-25" placeholder="Search...">
                                        <button class="btn btn-primary ms-2">Go</button>
                                        <button class="btn btn-secondary ms-2">Export</button>
                                    </div>

                                    <div class="d-flex justify-content-end gap-3">
                                        <button class="btn btn-primary">Create New</button>
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
                                    </div>

                                    <!-- Contact Information Form -->
                                    <h6 class="fw-bold">Contact Information</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Contact Type</label>
                                            <select class="form-select">
                                                <option>Business</option>
                                                <option>Personal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label">State</label>
                                            <select class="form-select">
                                                <option>Select</option>
                                                <option>MN</option>
                                                <option>IL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">SMS/Mobile #</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Time Zone</label>
                                            <select class="form-select">
                                                <option>Select</option>
                                                <option>PST</option>
                                                <option>CST</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-3">
                                        <button class="btn btn-danger">Failed Report</button>
                                        <button class="btn btn-success">Save</button>
                                        <button class="btn btn-secondary">Clear</button>
                                        <button class="btn btn-primary float-end" onclick="showScreen('screen2')">Next</button>
                                    </div>
                                </div>

                                <!-- Screen 2 -->
                                <div class="screen" id="screen2">
                                    <div class="container mt-4">
                                        <!-- Upload Section -->
                                        <div class="file-upload-section d-flex justify-content-between align-items-center">
                                            <h5 class="text-muted">Upload Contact File</h5>
                                            <span class="delete-file text-danger">Delete file</span>
                                        </div>

                                        <!-- File Information -->
                                        <p class="mt-3 file-info">
                                            You have just uploaded the file <strong>“File XXXX.xls”</strong> with <strong>14</strong> lines and <strong>8</strong> columns.
                                        </p>

                                        <!-- Contact Data Table -->
                                        <h5 class="mt-4">Contact Data</h5>
                                        <div class="table-container border">
                                            <table class="table table-bordered text-center">
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

                                        <!-- Navigation Buttons -->
                                        <div class="d-flex justify-content-center mt-4">
                                            <button class="btn btn-outline-dark px-4" onclick="showScreen('screen3')">Continue</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-secondary mt-3" onclick="showScreen('screen1')">Back</button>
                                    <button class="btn btn-primary mt-3" onclick="showScreen('screen3')">Next</button>
                                </div>

                                <!-- Screen 3 -->
                                <div class="screen" id="screen3">
                                    <div class="container border p-4">
                                        <h5 class="text-muted">Upload Contact File</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted"><em><strong id="uploadedFileName">File XXXX.xls</strong></em> with <strong>14</strong> lines and <strong>8</strong> columns.</p>
                                            <button class="btn btn-link text-dark">Modify file</button>
                                        </div>
                                        <hr>

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

                                        <div class="d-flex justify-content-center mt-3">
                                            <button class="btn btn-outline-dark px-4" onclick="showScreen('screen4')">Continue</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-secondary mt-3" onclick="showScreen('screen2')">Back</button>
                                    <button class="btn btn-primary mt-3" onclick="showScreen('screen4')">Next</button>
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
                                            <table class="table table-bordered">
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
                        </div>

                        <!-- My Network Tab -->
                        <div class="tab-pane fade" id="my-network">
                            <div class="container">
                                <h4 class="mb-3">Social Media Integration</h4>

                                <div class="social">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Enabled</th>
                                                <th>Digital Media Network</th>
                                                <th>Media Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Google -->
                                            <tr>
                                                <td><input type="checkbox" checked></td>
                                                <td>
                                                    <button class="login-btn"><i class="fab fa-google"></i> Log in with Google</button>
                                                </td>
                                                <td><span class="status-connected">Connected</span></td>
                                                <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                                            </tr>
                                            <!-- Apple -->
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td>
                                                    <button class="login-btn"><i class="fab fa-apple"></i> Log in with Apple</button>
                                                </td>
                                                <td><span class="status-disconnected">Dis-Connected</span></td>
                                                <td><button class="btn btn-outline-dark btn-sm">Connect</button></td>
                                            </tr>
                                            <!-- Facebook -->
                                            <tr>
                                                <td><input type="checkbox" checked></td>
                                                <td>
                                                    <button class="login-btn"><i class="fab fa-facebook"></i> Log in with Facebook</button>
                                                </td>
                                                <td><span class="status-connected">Connected</span></td>
                                                <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                                            </tr>
                                            <!-- Twitter -->
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td>
                                                    <button class="login-btn"><i class="fab fa-twitter"></i> Log in with Twitter</button>
                                                </td>
                                                <td><span class="status-connected">Connected</span></td>
                                                <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                                            </tr>
                                            <!-- Instagram -->
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td>
                                                    <button class="login-btn"><i class="fab fa-instagram"></i> Log in with Instagram</button>
                                                </td>
                                                <td><span class="status-disconnected">Dis-Connected</span></td>
                                                <td><button class="btn btn-outline-dark btn-sm">Connect</button></td>
                                            </tr>
                                            <!-- TikTok -->
                                            <tr>
                                                <td><input type="checkbox" checked></td>
                                                <td>
                                                    <button class="login-btn"><i class="fab fa-tiktok"></i> Log in with TikTok</button>
                                                </td>
                                                <td><span class="status-connected">Connected</span></td>
                                                <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <!-- My Templates Tab -->
                        <div class="tab-pane fade" id="my-templates">
                            <h5>My Templates</h5>
                            <p>Editor to be placed Here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing and Payments Tab -->
            <div class="tab-pane mb-5 border p-4" id="billing" role="tabpanel" aria-labelledby="billing">
                <div class="container">
                    <h2 class="fw-bold">(Company Name) Invoices</h2>
                    <div class="d-flex justify-content-center my-2">
                        <span class="text-success fw-bold me-3">In Progress</span>
                        <span class="text-danger fw-bold me-3">Need Payment</span>
                        <span class="text-dark fw-bold">Completed</span>
                    </div>

                    <!-- Invoice Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Broadcast Name</th>
                                    <th>Recipients</th>
                                    <th>Blasts</th>
                                    <th>Replies</th>
                                    <th>Purchase Date</th>
                                    <th>Credit Charge</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="text-danger">100120</a></td>
                                    <td class="text-danger">Michael Birthday Party</td>
                                    <td class="text-danger">31,080</td>
                                    <td>5</td>
                                    <td class="text-danger">0</td>
                                    <td class="text-danger">12/24/24</td>
                                    <td class="text-danger">543</td>
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
                                <tr >
                                    <td><a href="#" class="text-dark">102030</a></td>
                                    <td class="text-dark">B Cole Comedy Show</td>
                                    <td class="text-dark">405</td>
                                    <td>2</td>
                                    <td>243</td>
                                    <td>12/20/24</td>
                                    <td>1130</td>
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
                            </tbody>
                        </table>
                    </div>

                    <!-- Company Info -->
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h5 class="fw-bold">Company Name:</h5> Windy City Promotions
                            <div class="d-flex justify-content-between mt-3 mb-3">
                                 <span class="d-flex gap-3">
                                    <p class="fw-bold">City:</p>
                                    <p>Oswego</p>
                                </span>
                                </span>
                                <span class="d-flex gap-3">
                                    <p class="fw-bold">State:</p>
                                    <p>Illinois</p>
                                </span>
                                <span class="d-flex gap-3">
                                    <p class="fw-bold">Zipcode:</p>
                                    <p>60534</p>
                                </span>
                            </div>

                            <h5 class="fw-bold">Billing Email:</h5> abcwindy@gmail.com
                        </div>
                        <div class="col-md-4 text-end">
                            <h5><strong>Invoice Date:</strong> 12/20/24</h5>
                            <h5><strong>Invoice #:</strong> 102030</h5>
                            <h5><strong>Total Credit Due:</strong> 0</h5>
                        </div>
                    </div>

                    <!-- Blast Info -->
                    <h5 class="mt-4 fw-bold">Blast Information</h5>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Blast Name</th>
                                <th>Recipients</th>
                                <th>Blasts</th>
                                <th>Completed</th>
                                <th>Start Date</th>
                                <th>End State</th>
                                <th>Credit Cost</th>
                                <th>Success</th>
                                <th>Failure</th>
                                <th>Replies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>B Cole Comedy Show</td>
                                <td>405</td>
                                <td>2</td>
                                <td>2</td>
                                <td>11/14/2024</td>
                                <td>12/24/24</td>
                                <td>1130</td>
                                <td>784</td>
                                <td>16</td>
                                <td>521</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    

                    <!-- Service Cost -->
                    <h5 class="fw-bold mt-4">Service Cost Breakdown</h5>

                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Service Description</th>
                                <th>Credit Cost</th>
                                <th>Quantity</th>
                                <th>Total Credit Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SMS Contact Count</td>
                                <td>405</td>
                                <td>2</td>
                                <td>810</td>
                            </tr>
                            <tr>
                                <td>Image Cost</td>
                                <td>10</td>
                                <td>2</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>AI Usage</td>
                                <td>100</td>
                                <td>1</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <td>Additional OPT - Answer Reply</td>
                                <td>200</td>
                                <td>1</td>
                                <td>200</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold">Total Credit Cost:</td>
                                <td>1130</td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    

                    <!-- Schedule Information -->
                    <h5 class="fw-bold mt-4">Schedule</h5>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1/24/2025</td>
                                <td>10:00 PM CST</td>
                            </tr>
                            <tr>
                                <td>2/24/2025</td>
                                <td>09:00 PM CST</td>
                            </tr>
                            <tr>
                                <td>2/24/2025</td>
                                <td>09:00 PM CST</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td class="text-end fw-bold">Total Schedules:</td>
                                <td>2</td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-outline-dark px-4">Download Replies</button>
                        <div>
                            <button class="btn btn-success me-2 px-4">PAY</button>
                            <button class="btn btn-dark px-4">PRINT</button>
                        </div>
                    </div>

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

<script>
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
