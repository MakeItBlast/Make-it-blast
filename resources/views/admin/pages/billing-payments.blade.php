@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/billing.css') }}">
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

    <div class="tab-bg">

        <h2 class="fw-bold">(Company Name) Invoices</h2>
        <div class="d-flex justify-content-center my-2">
            <span class="text-success fw-bold me-3">In Progress</span>
            <span class="text-danger fw-bold me-3">Need Payment</span>
            <span class="text-dark fw-bold">Completed</span>
        </div>

        <!-- Invoice Table -->
        <div class="table-responsive">
            <table class=" dataTable table table-bordered text-center">
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
                    <tr>
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
    </div>

    <div class="tab-bg my-4">
            <!-- Company Info -->
        <div class="row mt-4">
            <div class="col-md-8">
                <h2 class="fw-bold">Company Name:</h2> Windy City Promotions
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

        <h2 class="my-4 fw-bold">Blast Information</h2>
        <div class="table-responsive">
            <table class=" dataTable table table-bordered">
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
    </div>


    <div class="tab-bg my-4">
        <!-- Service Cost -->
        <h2 class="fw-bold mt-4">Service Cost Breakdown</h2>

        <div class="table-responsive">
            <table class="dataTable table table-bordered">
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
    </div>

    <div class="tab-bg my-4">
        <!-- Schedule Information -->
        <h5 class="fw-bold mt-4">Schedule</h5>
        <div class="table-responsive">
            <table class="dataTable table table-bordered">
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
    </div>


    <div class="tab-bg my-4">
        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-outline-dark px-4">Download Replies</button>
            <div>
                <button class="btn btn-success me-2 px-4">PAY</button>
                <button class="btn btn-dark px-4">PRINT</button>
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



<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
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

</script>


@stop