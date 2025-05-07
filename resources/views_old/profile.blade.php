@include('header')
<link rel="stylesheet" href="{{ asset('/public/styles/profile.css') }}">

<body>
@if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mt-5 mb-5">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="accountTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="user-account-tab" data-bs-toggle="tab" data-bs-target="#user-account" type="button" role="tab"><span><i class="fa-solid fa-user-tie"></i>USER ACCOUNT</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="subscription-tab" data-bs-toggle="tab" data-bs-target="#subscription" type="button" role="tab"><span><i class="fa-solid fa-dollar-sign"></i>SUBSCRIPTION/CREDIT</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="payment-info-tab" data-bs-toggle="tab" data-bs-target="#payment-info" type="button" role="tab"><span><i class="fa-regular fa-credit-card"></i>PAYMENT INFORMATION</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab"><span><i class="fa-solid fa-headset"></i>CONTACT US</span></button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content border p-4" id="accountTabContent">
            <!-- USER ACCOUNT TAB -->
            <div class="tab-pane active" id="user-account" role="tabpanel" aria-labelledby="user-account-tab">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">User Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <select class="form-select">
                                <option selected>Select State</option>
                                <option value="1">State 1</option>
                                <option value="2">State 2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Zipcode</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Billing Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Billing Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-dark">SUBMIT</button>
                </form>

                <hr class="mt-4">

                <h6>Change Password</h6>
                <div class="border p-3">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Save</button>
                    </form>
                </div>
            </div>

            <!-- SUBSCRIPTION/CREDIT TAB -->
            <div class="tab-pane" id="subscription" role="tabpanel" aria-labelledby="subscription-tab">
                <div class="sub-table">
                    <table>
                        <thead>
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

                            <tr>
                                <td>Gold</td>
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

                            <tr>
                                <td>Silver</td>
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

                            <tr>
                                <td>Platinum</td>
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

                            <tr>
                                <td>Free</td>
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
                <p class="mt-3"><strong>Next Payment Due = $69.99</strong></p>

                <div class="form-section">
                    <h4>Purchase Credits</h4>
                    <div class="row mb-3">
                        <div class="col-md-6 sub">
                            <h5>Buy Subscription</h5>
                            <select class="form-select mb-2">
                                <option>Select Subscription</option>
                                <option>Basic Plan</option>
                                <option>Premium Plan</option>
                            </select>
                            <button class="btn btn-outline-primary">Add To List</button>
                        </div>
                        <div class="col-md-6 sub">
                            <h5>Buy Credits</h5>
                            <input type="text" class="form-control mb-2" placeholder="Enter Credits">
                            <button class="btn btn-outline-primary">Add To List</button>
                        </div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Duration</th>
                            <th>Credits</th>
                            <th>Cost</th>
                            <th>Discount</th>
                            <th>Yearly</th>
                            <th>Select Payment</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Plan</td>
                            <td>30</td>
                            <td>1000</td>
                            <td>$39.99</td>
                            <td class="red-text">- $119.97</td>
                            <td>$359.91</td>
                            <td>
                                <select class="form-select">
                                    <option>Monthly</option>
                                    <option>Yearly</option>
                                </select>
                            </td>
                            <td><button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button></td>
                        </tr>
                        <tr>
                            <td>Added Credits</td>
                            <td>-</td>
                            <td>200</td>
                            <td>$10.00</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td><button class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button></td>
                        </tr>
                    </tbody>
                </table>
                <p class="mt-3"><strong>Totals: 1200 | $49.99</strong></p>

                <h4 class="mt-4">Payment Information</h4>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="First Name">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="City">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="State">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Credit Card">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Expiration Date">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="CVV">
                    </div>
                </div>
                <button class="btn btn-success mt-3">Process Payment</button>
            </div>

            <!-- PAYMENT INFORMATION TAB -->
            <div class="tab-pane" id="payment-info" role="tabpanel" aria-labelledby="payment-info-tab">
                <div class="container-fluid">
                    <h4 class="mt-3">Payment Information</h4>

                    <!-- Payment Form -->
                    <form class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" placeholder="First Name">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" placeholder="City">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">State</label>
                                <select class="form-select">
                                    <option selected>Select State</option>
                                    <option>IL</option>
                                    <option>NY</option>
                                    <option>CA</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Credit Card</label>
                                <input type="text" class="form-control" placeholder="Credit Card">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Expiration Date</label>
                                <input type="text" class="form-control" placeholder="MM/YY">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" placeholder="CVV">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="defaultCard">
                                    <label class="form-check-label" for="defaultCard">Default Card</label>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-outline-primary w-100">Save</button>
                            </div>
                        </div>
                    </form>

                    <!-- Available Credit Cards Table -->
                    <h5>Available Credit Cards</h5>
                    <div class="table-responsive">
                        <table>
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
                                <tr>
                                    <td>Michael</td>
                                    <td>Jones</td>
                                    <td>Mission Drive</td>
                                    <td>IL</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>02/28</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>
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
                                    <td>Michael</td>
                                    <td>Jones</td>
                                    <td>Mission Drive</td>
                                    <td>IL</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>02/28</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>
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
                                    <td>Michael</td>
                                    <td>Jones</td>
                                    <td>Mission Drive</td>
                                    <td>IL</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>02/28</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>
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
                                    <td>Michael</td>
                                    <td>Jones</td>
                                    <td>Mission Drive</td>
                                    <td>IL</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>02/28</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>
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
                                    <td>Michael</td>
                                    <td>Jones</td>
                                    <td>Mission Drive</td>
                                    <td>IL</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>02/28</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>
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

                    <!-- Payment History Table -->
                    <h5 class="mt-4">My Payment History</h5>
                    <div class="table-responsive">
                        <table>
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
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>0909865</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>Premium Subscription</td>
                                    <td>1/23/2026</td>
                                    <td>$39.99</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>0909865</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>Premium Subscription</td>
                                    <td>1/23/2026</td>
                                    <td>$39.99</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>0909865</td>
                                    <td>XXXX-XXXX-XXXX-2453</td>
                                    <td>Premium Subscription</td>
                                    <td>1/23/2026</td>
                                    <td>$39.99</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CONTACT US TAB -->
            <div class="tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="container mt-4">
                    <h5>Contact Us</h5>
                    <form>
                        <!-- Title of Message -->
                        <div class="mb-3">
                            <label class="form-label">Title of Message</label>
                            <input type="text" class="form-control" placeholder="Enter title">
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Enter your message"></textarea>
                        </div>

                        <!-- Priority and Upload Image -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Priority</label>
                                <select class="form-select">
                                    <option selected>Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-8 d-flex align-items-end">
                                <label class="form-label me-2">Upload Image:</label>
                                <!-- Custom Upload Icon -->
                                <div class="custom-upload-icon" onclick="document.getElementById('imageUpload').click()">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <input type="file" class="d-none" id="imageUpload" onchange="displayFileName()">
                                <span class="ms-3" id="fileName">No file chosen</span>
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFile()" style="display: none;" id="removeButton">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Send Button -->
                        <button type="submit" class="btn btn-outline-dark">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
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
    </script>
</body>

</html>