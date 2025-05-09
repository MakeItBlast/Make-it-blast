@extends('admin.layout.app')


@section('styles')
<link rel="stylesheet" href="{{ asset('styles/create-blast.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    <form method="POST">
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
                                    <input type="checkbox" id="smsMessage" required>
                                    <label for="smsMessage">SMS Message <span class="text-danger">*</span></label>
                                </div>

                                <div class="idmsg">
                                    <input type="checkbox" id="emailMessage" class="ms-3" required>
                                    <label for="emailMessage">Email Message <span class="text-danger">*</span></label>
                                </div>

                                <div class="idmsg">
                                    <input type="checkbox" id="digitalMedia" class="ms-3" required>
                                    <label for="digitalMedia">Digital Media <span class="text-danger">*</span></label>
                                </div>

                            </div>
                        </div>

                        <!-- Blast Name and Contact Type Selection -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="blastName" class="form-label">Blast Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="blastName" name="blast_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contactType" class="form-label">Contact Type <span class="text-danger">*</span></label>
                                <div class="d-flex">

                                    {{-- Select + add button --}}
                                    <select id="contactType" name="contact_type" class="form-select" required>
                                        <option value="">Select Contact Type</option>
                                        @foreach ($contactTypes->where('status', 'active') as $contactType)
                                        <option value="{{ $contactType->id }}">{{ $contactType->contact_type }}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-danger ms-2" id="addCTypetoCtypeSelectedBtn">
                                        Add to list
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- All Contact Checkbox -->
                        <div class="cnc-type">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="allContact">
                                <label class="form-check-label" for="allContact">All Contact</label>
                            </div>

                            <!-- Contact Type Selected -->
                            <div class="mb-3">
                                <label class="form-label">Contact Type Selected</label>
                                {{-- Chips live in here --}}
                                <div id="storeDataofContactType"
                                    class="border p-2 mt-2 d-flex flex-wrap gap-2"
                                    style="height:100px;overflow-y:auto;">
                                </div>




                                <!-- <button type="button" id="getDataAccoringToContactListSelected" onclick="abac()">Fetch Contacts</button> -->
                            </div>
                        </div>
                    </div>

                    <div class="tab-bg mt-4 mb-4">
                        <!-- Blast Contact List Table -->
                        <h5 class="mt-4">Blast Contact List</h5>
                        <div class="table-responsive">
                            <table class="dataTable table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Contact Type id</th>
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
                                <tbody id="contactList-table-body">
                                

                                    @foreach ($contactList as $contact)
                                    <tr>
                                        <td>{{ $contact->contact_type_id }}</td>
                                        <td>{{ $contact->contactType->contact_type }}</td>
                                        <td contenteditable="true" data-id="{{ $contact->id }}" data-field="c_fname">{{ $contact->c_fname }}</td>
                                        <td contenteditable="true" data-id="{{ $contact->id }}" data-field="c_lname">{{ $contact->c_lname }}</td>
                                        <td contenteditable="true" data-id="{{ $contact->id }}" data-field="c_city">{{ $contact->c_city }}</td>
                                        <td contenteditable="true" data-id="{{ $contact->id }}" data-field="c_state">{{ $contact->c_state }}</td>
                                        <td data-id="{{ $contact->id }}" data-field="c_timezone">{{ $contact->c_timezone }}</td>
                                        <td contenteditable="true" data-id="{{ $contact->id }}" data-field="c_phno">{{ $contact->c_phno }}</td>
                                       <td contenteditable="true" data-id="{{ $contact->id }}" data-field="c_email" title="{{ $contact->c_email }}">{{ Str::limit($contact->c_email, 12, '...') }}</td>
                                       <!-- Operation Buttons -->
                                        <td>
                                            <div class="action-btns">
                                                <a class="btn btn-sm edit-btn" href="#"> <i class="fa-solid fa-pencil"></i></a>
                                                <a href="#" class="btn btn-outline-primary btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Total Contacts for Blast -->
                        <p class="text-end fw-bold">Total Contacts for Blast: {{ count($contactList) }}</p>

                        <!-- Credits Section -->
                        <div class="credits-section text-center custom-border py-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <p>Credits Available<br><strong>{{$totalCredits ?? ''}}</strong></p>
                                <!-- <p>Current Used<br><strong>18</strong></p>
                                <p>Remaining Credits<br><strong>482</strong></p> --> 
                                <a href="{{ url('subscription') }}" id="b-m-credit" class="btn btn-outline-success">
                                    <span>Buy More Credits</span>
                                </a>
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
                                <h3>Step 2</h3>
                                <div class="d-flex justify-content-between align-items-center">

                                    <label for="messageEditor" class="blast form-label"><strong>(BLAST NAME)</strong> Message Editor</label>

                                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#resourceModal">
                                        <span>Add Link or Media</span>
                                    </button>
                                </div>

                                <!-- Resource Select Boxes -->

                                <div class="row gap-5 my-4">
                                    @if(isset($links) || isset($medias))
                                    <div class="d-flex gap-5 my-4">
                                        @if(isset($links))
                                        <select class="form-select" onchange="insertIntoEditor(this)">
                                            <option value="">Select Link</option>
                                            @foreach($links as $link)
                                            <option value="{{ $link->rsrc_value }}" data-id="{{ $link->id }}">{{ ucfirst($link->rsrc_name) }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @if(isset($medias))
                                        <select class="form-select" onchange="insertIntoEditor(this)">
                                            <option value="">Select Media</option>
                                            @foreach($medias as $media)
                                            <option value="{{ url('public/' . $media->rsrc_value) }}" data-id="{{ $media->id }}">{{ ucfirst($media->rsrc_name) }}</option>
                                            @endforeach
                                        </select>
                                        @endif

                                        <!-- Static Data Fields Dropdown -->
                                        <select class="form-select" onchange="insertIntoEditor(this)">
                                            <option value="">Select Data Field</option>
                                            <option value="c_fname">First Name</option>
                                            <option value="c_lname">Last Name</option>
                                            <option value="c_email">Email</option>
                                            <option value="c_phone">Phone Number</option>
                                        </select>
                                    </div>
                                    @endif
                                </div>
                                <textarea name="tempelate_structure" id="summernote" required></textarea>
                            </div>

                            <!-- Buttons Below Editor -->
                            <div class="d-flex flex-wrap mt-3 gap-2">
                                <select id="templateSelect" name="tempelate_id" class="form-select w-auto" onchange="populateStructure(this)">
                                    <option value="" selected>Select Template</option>
                                    @foreach ($tempelateStructures as $structure)
                                    <option value="{{ $structure->id }}">{{ $structure->temp_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="aiMyBlast" class="btn btn-danger">AI MY BLAST</button>
                                <button type="button" id="saveTemplate" class="btn btn-secondary" onclick="saveBlastStructure()">Save as Template</button>
                                <button type="button" id="undoAction" class="btn btn-dark">Undo</button>
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
                        <h2 class="mb-3">(BLAST NAME) Additional Options</h2>

                        <!-- Include Yes or No Answer -->
                        <div class="form-check mb-3" id="toggleVisibilityCheckbox">
                            <input class="form-check-input" type="checkbox" id="includeAnswer">
                            <label class="form-check-label text-danger" for="includeAnswer">
                                Include (Yes or No) Answer
                            </label>
                        </div>

                        <div class="cont" id="questionContainer" style="display: none;">
                            <!-- Input Question -->
                            <div class="mb-3">
                                <label for="inputQuestion" class="form-label">Input Question:</label>
                                <input type="text" class="form-control" id="inputQuestion" name="input_question">
                            </div>

                            <!-- Before and After Message -->
                            <div class="mb-3">

                                <label class="form-check-label me-3" for="beforeMessage">
                                    <input class="form-check-input" type="radio" name="msg_position" value="up" id="beforeMessage">
                                    <span>Before Message</span>
                                </label>


                                <label class="form-check-label" for="afterMessage">
                                    <input class="form-check-input" type="radio" name="msg_position" value="down" id="afterMessage">
                                    <span>After Message</span>
                                </label>
                            </div>

                            <!-- Add Keywords and Keywords List -->
                            <div class="row g-3 mb-3">
                                <!-- Add Keywords -->
                                <div class="col-md-6">
                                    <label for="addKeywords" class="form-label">Add Keywords</label>
                                    {{-- keyword entry --}}
                                    <div class="d-flex">
                                        <input type="text" class="form-control" id="addKeywords" placeholder="Enter a keyword">
                                        <button type="button" class="btn btn-danger ms-2" id="addKeywordBtn">Add to list</button>
                                    </div>
                                </div>

                                <!-- Keywords List -->
                                <div class="col-md-6">
                                    <label class="form-label">Key Words List</label>
                                    <div id="keywordsList"
                                        class="border p-2 mt-2 d-flex flex-wrap gap-2"
                                        style="min-height:100px;overflow-y:auto;">
                                        {{-- chips will be injected here --}}
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Credits Section -->
                        <div class="credits-section text-center custom-border py-3">
                            <div class="d-flex justify-content-between">
                                <p>Credits Available<br><strong>500</strong></p>
                                <p>Current Used<br><strong>18</strong></p>
                                <p>Remaining Credits<br><strong>482</strong></p>
                                <button type="button" class="btn btn-outline-dark b-cred">Buy Credits</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-center gap-3 mt-2">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-2">Back</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#optionModal">Next</button>
                </div>

            </div>

            <!-- Screen 4  -->
            <div class="screen" id="screen-4">
                <div class="head d-flex justify-content-between mb-3">
                    <h2 class="mb-3">New Blast Form</h2>
                    <h5>Step 4</h5>
                </div>
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
                                <button type="button" class="btn btn-outline-dark w-100" id="clickToScheduleDate">Add to List</button>
                            </div>
                        </div>
                    </div>


                    <div class="tab-bg mt-4 mb-4">
                        <div class="mb-3">
                            <h5>Scheduled Dates</h5>
                            {{-- chips container --}}
                            <div id="scheduledDates"
                                class="border p-2 d-flex flex-column gap-2"
                                style="min-height:100px;overflow-y:auto;">
                                {{-- schedule chips get injected here --}}
                            </div>
                            <p class="mt-2">Blast Total = 2</p>
                        </div>
                        <script>

                        </script>


                        <div class="credits-info">
                            <div class="d-flex justify-content-between">
                                <p>Credits Available <br><span class="fw-bold">500</span></p>
                                <p>Current Used <br><span class="fw-bold">18</span></p>
                                <p>Remaining Credits <br><span class="fw-bold">482</span></p>
                                <button type="button" class="btn btn-outline-dark b-cred">Buy Credits</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-2">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-3">Back</button>
                    <button type="button" class="btn btn-primary next-btn" data-target="#screen-5">Next</button>
                </div>
            </div>

            <!-- Screen for scheduling -->
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
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
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
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
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
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="credits-info">
                        <div class="d-flex gap-5 justify-content-between mb-3 mt-3">
                            <p>Credits Available <span class="fw-bold">500</span></p>
                            <p>Remaining Credits <span class="fw-bold">482</span></p>
                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-primary" onclick="showPreview()">Preview</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="d-flex gap-5 justify-content-center mb-3 mt-3">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-4">Back</button>
                    <button type="button" id="store_blast_data_schedule" class="btn btn-success">Process</button>
                    <!-- <button type="submit" class="btn btn-success">Save</button> -->
                </div>
            </div>

            <!-- Screen for send Now  -->
            <div class="screen" id="screen-6">
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
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
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
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
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
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="credits-info">
                        <div class="d-flex gap-5 justify-content-between mb-3 mt-3">
                            <p>Credits Available <span class="fw-bold">500</span></p>
                            <p>Remaining Credits <span class="fw-bold">482</span></p>
                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-primary" onclick="showPreview()">Preview</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Button -->


                <div class="d-flex gap-5 justify-content-center mb-3 mt-3">
                    <button type="button" class="btn btn-secondary back-btn" data-target="#screen-3">Back</button>
                    <button type="button" id="store_blast_data" class="btn btn-success">Process</button>
                    <!-- <button type="submit" class="btn btn-success">Save</button> -->
                </div>
            </div>
        </div>
</div>


</form>


<!-- modal boxes -->

<!-- Options Modal-->
<div class="modal fade" id="optionModal" tabindex="-1" aria-labelledby="optionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="optionModalLabel">Choose an Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <h3>Please select an option to proceed</h3>
                <button type="button" class="btn btn-success m-2 next-btn" data-target="#screen-4">Schedule for later</button>
                <button type="button" class="btn btn-success m-2 next-btn" data-target="#screen-6">Send Now</button>
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

<!-- Preview modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Rendered preview will be injected here -->
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <p class="text-capitalize">{{$footerMessage ?? 'No Footer Message'}}</p>
            </div>
        </div>
    </div>
</div>


<!-- add resource modal -->
<div class="modal fade" id="resourceModal" tabindex="-1" aria-labelledby="resourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resourceModalLabel">Add Resource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex gap-3">
                    <!-- Add Link -->
                    <div class="col md-6">
                        <form id="linkForm" method="POST" action="{{url('store-link')}}">
                            @csrf
                            <div id="linkSuccessMsg" class="alert alert-success d-none">Link added successfully!</div>
                            <label>URL</label>
                            <div class="col">
                                <input type="text" name="url_text" class="form-control my-3" placeholder="Please Enter Text">
                                <input type="url" name="url_value" class="form-control my-3" placeholder="Please Enter Link">
                            </div>
                            <button type="button" class="btn btn-success mt-3" onclick="submitLinkForm()">Add Link</button>
                        </form>
                    </div>

                    <!-- Upload Media -->
                    <div class="col md-6">
                        <form id="mediaForm" method="POST" action="{{ url('store-media') }}" enctype="multipart/form-data">
                            @csrf
                            <div id="mediaSuccessMsg" class="alert alert-success d-none">Media uploaded successfully!</div>
                            <label for="media_text" class="form-label">Media Name</label>
                            <input type="text" name="media_text" id="media_text" class="form-control my-2" placeholder="Please Enter Text" required>

                            <label for="media_file" class="form-label">Upload Image or Video</label>
                            <div class="d-flex align-items-center mb-3">
                                <label for="media_file" class="custom-upload-icon" style="cursor: pointer;">
                                    <i class="fa-solid fa-cloud-arrow-up fa-2x"></i>
                                </label>
                                <input type="file" name="media_file" class="d-none" id="media_file" accept="image/*,video/*" onchange="displayMediaFile()" required>
                                <span class="ms-3" id="fileName" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    No file chosen
                                </span>
                                <button type="button" class="btn btn-outline-danger ms-2 rounded-circle" onclick="removeMediaFile()" style="display: none;" id="removeButton">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <button type="button" class="btn btn-primary" onclick="submitMediaForm()">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.43/builds/moment-timezone-with-data.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    //for options modal 
    $(document).ready(function() {
        let contactList = <?= $contactList ?>;
        console.log('contactList', contactList);

        // Track displayed contact IDs to avoid duplicates
        let displayedContactIds = new Set();

        // Clear table on page load
        $('#contactList-table-body').empty();

        function getContactTypeIds() {
            let ids = [];
            $('#storeDataofContactType span').each(function() {
                ids.push($(this).data('contact_type_id'));
            });
            return ids;
        }

        // Get all unique contact type IDs from contactList
        function getAllContactTypeIds() {
            let uniqueIds = new Set();
            contactList.forEach(contact => {
                uniqueIds.add(contact.contact_type_id);
            });
            return Array.from(uniqueIds);
        }

        function filterTableByContactTypeId(contactTypeId) {
            let rows = '';
            contactList.forEach(contact => {
                // Skip if already displayed
                if (displayedContactIds.has(contact.id)) return;

                if (contactTypeId == contact.contact_type_id) {
                    rows += `
                    <tr>
                        <td>${contact.contact_type_id}</td>
                        <td>${contact.contact_type.contact_type}</td>
                        <td contenteditable="true" data-id="${contact.id}" data-field="c_fname">${contact.c_fname}</td>
                        <td contenteditable="true" data-id="${contact.id}" data-field="c_lname">${contact.c_lname}</td>
                        <td contenteditable="true" data-id="${contact.id}" data-field="c_city">${contact.c_city}</td>
                        <td contenteditable="true" data-id="${contact.id}" data-field="c_state">${contact.c_state}</td>
                        <td data-id="${contact.id}" data-field="c_timezone">${contact.c_timezone}</td>
                        <td contenteditable="true" data-id="${contact.id}" data-field="c_phno">${contact.c_phno}</td>
                        <td contenteditable="true" data-id="${contact.id}" data-field="c_email">${contact.c_email}</td>
                        <td>
                            <div class="action-btns">
                                <a class="btn btn-sm edit-btn" href="#"><i class="fa-solid fa-pencil"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                    // Mark this contact as displayed
                    displayedContactIds.add(contact.id);
                }
            });
            return rows;
        }

        // Add selected contact types to the table (append mode)
        $("#addCTypetoCtypeSelectedBtn").on('click', function() {
            let contactTypeIds = getContactTypeIds();
            console.log('Selected Contact Type IDs:', contactTypeIds);

            if (contactList.length) {
                contactTypeIds.forEach(contactTypeId => {
                    let newRows = filterTableByContactTypeId(contactTypeId);
                    $('#contactList-table-body').append(newRows);
                });
            }
        });

        // Handle "All Contacts" checkbox
        $("#allContact").on('change', function() {
            if ($(this).is(':checked')) {
                // Clear displayed contacts tracking
                displayedContactIds.clear();

                // Clear the table
                $('#contactList-table-body').empty();

                // Get all unique contact type IDs
                let allContactTypeIds = getAllContactTypeIds();
                console.log('All Contact Type IDs:', allContactTypeIds);

                if (contactList.length) {
                    allContactTypeIds.forEach(contactTypeId => {
                        let newRows = filterTableByContactTypeId(contactTypeId);
                        $('#contactList-table-body').append(newRows);
                    });
                }
            } else {
                // Optional: Clear table when unchecked if desired
                // displayedContactIds.clear();
                // $('#contactList-table-body').empty(); 
            }
        });
    });

    // Open the modal when clicking the open button
    $('#openModalBtn').on('click', function() {
        $('#optionModal').modal('show');
    });

    // Close the modal when clicking any button inside the modal
    $('#optionModal').on('click', 'button', function() {
        $('#optionModal').modal('hide');
    });


    // For displaying the value of blast name 
    $(document).ready(function() {
        $('#blastName').on('input', function() {
            let blastName = $(this).val().trim();

            if (blastName) {
                $('h2.mb-3').text(blastName + ' Message Editor');
                $('label.blast').html('<strong>' + blastName + '</strong> Message Editor');
            } else {
                $('h2.mb-3').text('(Blast Name) Message Editor');
                $('label.blast').html('<strong>(BLAST NAME)</strong> Message Editor');
            }
        });
    });

    // for hiding question div 

    $(document).ready(function() {
        // Initially hide the .cont div
        $('#questionContainer').hide();

        // Toggle visibility when the checkbox is clicked
        $('#toggleVisibilityCheckbox input').change(function() {
            if ($(this).is(':checked')) {
                $('#questionContainer').fadeIn(); // Show the .cont div with a fade-in effect
            } else {
                $('#questionContainer').fadeOut(); // Hide the .cont div with a fade-out effect
            }
        });
    });

    // for reload alert 
    window.addEventListener("beforeunload", function(e) {
        e.preventDefault();
        e.returnValue = "";
    });


    //for real time editing of contact list 

    document.addEventListener("DOMContentLoaded", function() {
        const editableCells = document.querySelectorAll('[contenteditable="true"]');

        editableCells.forEach(cell => {
            cell.addEventListener("blur", function() {
                const id = this.getAttribute("data-id");
                const field = this.getAttribute("data-field");
                const value = this.innerText.trim();
                console.log('id', id);
                console.log('field', field);
                console.log('value', value);

                fetch(`/make-it-blast/contacts/update-inline`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify({
                            id,
                            field,
                            value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert("Update failed!");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Error updating value.");
                    });
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
            "pagingType": "simple_numbers",
            "language": {
                "search": "", // Removes "Search:" label
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            },
            "initComplete": function() {
                $('.dataTables_filter input[type="search"]')
                    .attr('placeholder', 'Search here...')
                    .css({
                        'width': '200px'
                    }); // optional: styling
            }
        });
    });

    /**
     * Keyword chip logic
     */
    document.getElementById('addKeywordBtn').addEventListener('click', () => {
        const input = document.getElementById('addKeywords');
        const keywordRaw = input.value.trim();
        if (!keywordRaw) return;

        const keyword = keywordRaw.toLowerCase(); // normalise for duplicate test
        // Prevent duplicates
        if (document.querySelector(`[data-keyword="${keyword}"]`)) {
            input.value = '';
            return;
        }

        // Chip template --------------------------------------------------------
        const chip = document.createElement('span');
        chip.className = 'badge text-dark d-inline-flex align-items-center';
        chip.dataset.keyword = keyword; // handy attribute to find duplicates
        chip.innerHTML = `
        ${keywordRaw}
        <button type="button" class="btn-close ms-2" aria-label="Remove"></button>
        <input type="hidden" name="keyword_arr[]" value="${keywordRaw}">
    `;

        // remove handler
        chip.querySelector('button').addEventListener('click', () => chip.remove());

        // add to container
        document.getElementById('keywordsList').appendChild(chip);

        // reset input
        input.value = '';

        let keywordElements = document.querySelectorAll('#keywordsList span');
        let keywords = Array.from(keywordElements).map(span => span.getAttribute('data-keyword'));

        console.log(keywords); // This will log an array of all the data-keyword values

    });

    /**
     * Helpers ------------------------------------------------------------
     */
    const fmt = (date) => date.toISOString().split('T')[0]; // yyyy-mm-dd

    /**
     * Schedule chip logic
     */
    document.getElementById('clickToScheduleDate').addEventListener('click', () => {
        const dateVal = document.getElementById('blastDate').value.trim();
        const timeVal = document.getElementById('blastTime').value.trim();
        const tzSel = document.getElementById('timeZone');
        const tzVal = tzSel.value;
        const tzText = tzSel.options[tzSel.selectedIndex]?.text?.trim();

        // Basic validation ------------------------------------------------
        if (!dateVal || !timeVal || !tzVal) return;

        // Use a composite key to prevent duplicates (same date+time+tz)
        const dupKey = `${dateVal}_${timeVal}_${tzVal}`;
        if (document.querySelector(`[data-sched-key="${dupKey}"]`)) return;

        // Chip markup -----------------------------------------------------
        const chip = document.createElement('div');
        chip.className = 'alert alert-secondary py-1 px-2 d-flex justify-content-between align-items-center mb-0';
        chip.dataset.schedKey = dupKey;
        chip.innerHTML = `
        <div>
            <strong>${dateVal}</strong> &nbsp;|&nbsp; ${timeVal} &nbsp;|&nbsp; ${tzText}
        </div>
        <button type="button" class="btn-close ms-2" aria-label="Remove"></button>

        <!-- hidden inputs for backend -->
        <input type="hidden" name="schedule_date[]"  value="${dateVal}">
        <input type="hidden" name="schedule_time[]"  value="${timeVal}">
        <input type="hidden" name="schedule_tz[]"    value="${tzVal}">
    `;

        // Delete handler
        chip.querySelector('button').addEventListener('click', () => chip.remove());

        // Inject into container
        document.getElementById('scheduledDates').appendChild(chip);

        // Optional: clear pickers
        document.getElementById('blastDate').value = '';
        document.getElementById('blastTime').value = '';
        tzSel.selectedIndex = 0;
    });


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

    //for preview modal
    function showPreview() {
        const content = $('#summernote').summernote('code');
        const question = document.getElementById("inputQuestion").value.trim();
        const msgPosition = document.querySelector('input[name="msg_position"]:checked')?.value;

        // Build question HTML block
        let questionHTML = '';
        if (question) {
            questionHTML = `
            <div class="mb-3">
                <p><strong>Please answer this question.</strong></p>
                <p><strong>Question:</strong> ${question}</p>
                <div>
                    <button class="btn btn-success me-2">Yes</button>
                    <button class="btn btn-danger">No</button>
                </div>
            </div>
        `;
        }

        // Combine question and content
        let finalHTML = '';
        if (msgPosition === 'up') {
            finalHTML = questionHTML + content;
        } else {
            finalHTML = content + questionHTML;
        }

        document.getElementById('previewContent').innerHTML = finalHTML;
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }

    // for adding links and images to summernote 
    function insertIntoEditor(selectEl) {
        const value = selectEl.value;
        const text = selectEl.options[selectEl.selectedIndex].text;
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const dataId = selectedOption.dataset.id;
        // console.log('dataId',dataId);
        if (!value) return;

        let node;
        const isImage = value.match(/\.(jpeg|jpg|gif|png|webp|svg)$/i);
        const isLink = value.startsWith("http") || value.includes(".");

        if (isImage) {
            node = document.createElement("img");
            node.src = value;
            node.alt = `[${text}]`;
            node.style.maxWidth = "100%";
            node.setAttribute('data-id', dataId);
        } else if (isLink) {
            node = document.createElement("a");
            node.href = value;
            node.target = "_blank";
            node.innerText = `[${text}]`;
            node.setAttribute('data-id', dataId);
        } else {
            // For data fields like 'c_fname', insert the visible label like [[ First Name ]]
            node = document.createTextNode(`[${text}]`);
        }

        const br = document.createElement("br");

        $('#summernote').summernote('editor.insertNode', node);
        $('#summernote').summernote('editor.insertNode', br);

        selectEl.selectedIndex = 0;
    }



    // for modalbox submit

    function submitLinkForm() {
        const form = document.getElementById('linkForm');
        const url_text = form.url_text.value;
        const url_value = form.url_value.value;

        $.ajax({
            url: '{{ url("store-link") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                url_text: url_text,
                url_value: url_value
            },
            success: function(response) {
                console.log('ab', response);
                if (response.status) {
                    $('#linkForm')[0].reset();
                    $('#linkSuccessMsg').removeClass('d-none').text('Link added successfully!');
                } else {
                    $('#linkSuccessMsg').removeClass('alert-success').addClass('alert-danger').removeClass('d-none').text('Something went wrong!')
                }

            }

        });
    }

    function submitMediaForm() {
        const form = document.getElementById('mediaForm');
        const formData = new FormData(form);
        console.log('formData', formData);

        $.ajax({
            url: '{{ url("store-media") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function(response) {
                if (response.status) {
                    $('#mediaForm')[0].reset();
                    $('#fileName').text('No file chosen');
                    $('#removeButton').hide();
                    $('#mediaSuccessMsg')
                        .removeClass('d-none alert-danger')
                        .addClass('alert-success')
                        .text('Media uploaded successfully!');
                } else {
                    $('#mediaSuccessMsg')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .removeClass('d-none')
                        .text('Something went wrong!');
                }
            },
            error: function(xhr) {
                // Optional: show detailed error
                console.error(xhr.responseText);
                $('#mediaSuccessMsg')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .removeClass('d-none')
                    .text('Upload failed. Please try again.');
            }
        });
    }


    // Set initial keywords only once when the page loads
    // window.addEventListener("DOMContentLoaded", function () {
    //     var keywordsList = document.getElementById("keywordsList");
    //     if (keywordsList.value.trim() === "") {
    //         keywordsList.value = "business\npersonal";
    //     }
    // });

    // document.getElementById("addKeywordBtn").addEventListener("click", function () {
    //     var keywordInput = document.getElementById("addKeywords");
    //     var keywordValue = keywordInput.value.trim();

    //     // Check if input is not empty
    //     if (keywordValue) {
    //         var keywordsList = document.getElementById("keywordsList");

    //         // Append the user-entered keyword
    //         keywordsList.value += "\n" + keywordValue;
    //         keywordInput.value = "";

    //     } else {
    //         alert("Please enter a keyword.");
    //     }
    // });




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

    /* ---------- helper: create a chip ---------- */
    function createContactChip(id, label, origin = 'manual') {
        if (document.getElementById(`chip-ctype-${id}`)) return; // duplicate guard

        const chip = document.createElement('span');
        chip.className = 'badge bg-secondary d-inline-flex align-items-center';
        chip.id = `chip-ctype-${id}`;
        chip.dataset.contact_type_id = `${id}`;
        chip.dataset.origin = origin; // 'manual' or 'all'
        chip.innerHTML = `${label}<button type="button" class="btn-close btn-close-white ms-2" aria-label="Remove"></button><input type="hidden" name="contact_type_ids[]" value="${id}">`;
        chip.querySelector('button').addEventListener('click', () => chip.remove());
        document.getElementById('storeDataofContactType').appendChild(chip);
    }

    /* ---------- manual “Add to list” button ---------- */
    document.getElementById('addCTypetoCtypeSelectedBtn')
        .addEventListener('click', () => {
            const select = document.getElementById('contactType');
            const id = select.value;
            if (!id) return; // nothing chosen
            const label = select.options[select.selectedIndex].text.trim();
            createContactChip(id, label, 'manual');
            select.value = ''; // reset
        });

    /* ---------- “All Contact” checkbox ---------- */
    document.getElementById('allContact').addEventListener('change', (e) => {
        const container = document.getElementById('storeDataofContactType');
        if (e.target.checked) {
            document.querySelectorAll('#contactType option').forEach(opt => {
                const id = opt.value;
                if (!id) return; // skip placeholder
                createContactChip(id, opt.text.trim(), 'all');
            });
        } else {
            container.querySelectorAll('[data-origin="all"]').forEach(chip => chip.remove());
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
                ['view', ['fullscreen', 'codeview', 'help']],

            ],

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


    //functio to set the contact type from select to div
    function addCTypetoCtypeSelected() {
        const selectElement = document.getElementById('contactType');
        const storeDiv = document.getElementById('storeDataofContactType');
        const selectedText = selectElement.options[selectElement.selectedIndex].text.trim();

        const existingItems = storeDiv.innerText.split('\n').map(item => item.trim());

        if (selectedText !== '' && !existingItems.includes(selectedText)) {
            storeDiv.innerHTML += `${selectedText}<br>`;
        } else if (existingItems.includes(selectedText)) {
            alert("This item already exists in the list.");
        }

        selectElement.selectedIndex = 0;
    }

    // // New function to handle checkbox behavior
    // function toggleAllContactTypes(checkbox) {
    //     const storeDiv = document.getElementById('storeDataofContactType');
    //     const selectElement = document.getElementById('contactType');

    //     if (checkbox.checked) {
    //         storeDiv.innerHTML = '';

    //         // Start from index 1 to skip the placeholder (index 0)
    //         for (let i = 1; i < selectElement.options.length; i++) {
    //             const text = selectElement.options[i].text.trim();
    //             if (text !== '') {
    //                 storeDiv.innerHTML += `${text}<br>`;
    //             }
    //         }
    //     } else {
    //         storeDiv.innerHTML = '';
    //     }
    // }

    //get Data Accoring To Contact List Selected ajax
    function abac() {

        const getData = document.getElementById('storeDataofContactType');
        const contactList = getData.innerText.trim().split('\n').filter(item => item !== '');

        console.log("Contact Types:", contactList);

        $.ajax({
            url: '{{ url("fetch-contacts-according-to-contactType") }}', // replace with your route
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                items: contactList
            },
            success: function(response) {
                alert('Data submitted!');
                console.log(response);
            },
            error: function(xhr) {
                alert('Something went wrong!');
                console.log(xhr.responseText);
            }
        });


    }

    function saveBlastStructure() {
        var content = $('#summernote').summernote('code');

        console.log('Saved Template Content:', content);


        $.ajax({
            url: '{{ url("save-structure-to-blast-tbl") }}', // replace with your route
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                structure: content
            },
            success: function(response) {
                alert('Data submitted!');
                console.log(response);
            },
            error: function(xhr) {
                alert('Something went wrong!');
                console.log(xhr.responseText);
            }
        });



    }


    function populateStructure() {
        const idOfStructure = document.getElementById('templateSelect').value;

        console.log('idOfStructure', idOfStructure);

        $.ajax({
            url: '{{ url("get-temp-structure-using-id") }}', // replace with your route
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                idOfStructure: idOfStructure
            },
            success: function(response) {
                console.log('resp-', response['template_structure']);
                $('#summernote').summernote('code', response['template_structure']);
            },
            error: function(xhr) {

                console.log(xhr.responseText);
            }
        });

    }


    function addkeywordtodb() {
        const addKeywords = document.getElementById('addKeywords').value;

        console.log('addKeywords', addKeywords);

        $.ajax({
            url: '{{ url("store-keyword-in-db") }}', // replace with your route
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                addKeywords: addKeywords
            },
            success: function(addKeywords) {
                console.log('addKeywords-', addKeywords);
            },
            error: function(xhr) {

                console.log(xhr.responseText);
            }
        });
    }

    //ai my blast

    $('#aiMyBlast').on('click', function(e) {
        const rawdata = $('#summernote').summernote('code');
        console.log('AI enhance', rawdata);
        $.ajax({
            url: '{{ url("/enhance-prompt") }}', // replace with your route
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                rawdata: rawdata
            },
            success: function(resp) {
                console.log('resp-', resp);
                $('#summernote').summernote('reset');
                $('#summernote').summernote('code', resp);
            },
            error: function(xhr) {

                console.log(xhr.responseText);
            }
        });
    });

    //add schedule dates to the div
    //     document.querySelector('#clickToScheduleDate').addEventListener('click', function () {
    //     const date = document.getElementById('blastDate').value;
    //     const time = document.getElementById('blastTime').value;
    //     const timeZone = document.getElementById('timeZone').value;
    //     const textarea = document.getElementById('scheduledDates');

    //     if (!date || !time || timeZone === "Select Time Zone") {
    //         alert("Please fill in all fields before adding to the list.");
    //         return;
    //     }

    //     const newEntry = `${date} ${time} (${timeZone})`;
    //     textarea.value += newEntry + '\n';

    //     console.log('scheduledDates', scheduledDates);
    // });

    //sending all the data to backend 
    $('#store_blast_data, #store_blast_data_schedule').on('click', function(e) {
        e.preventDefault();

        const blastName = document.getElementById('blastName').value;
        const storeDataofContactType = document.querySelectorAll('#storeDataofContactType input');
        const ctype = Array.from(storeDataofContactType).map(input => input.getAttribute('value'));

        const summernote = document.getElementById('summernote').value;
        const inputQuestion = document.getElementById('inputQuestion').value;

        const positionQuestion = document.querySelector('input[name="msg_position"]:checked')?.value || '';

        let keywordElements = document.querySelectorAll('#keywordsList span');
        let keywords = Array.from(keywordElements).map(span => span.getAttribute('data-keyword'));

        const scheduledItems = document.querySelectorAll('#scheduledDates .alert');
        const scheduleData = [];
        scheduledItems.forEach(item => {
            const date = item.querySelector('input[name="schedule_date[]"]').value;
            const time = item.querySelector('input[name="schedule_time[]"]').value;
            const tz = item.querySelector('input[name="schedule_tz[]"]').value;
            scheduleData.push({
                date,
                time,
                timezone: tz
            });
        });

        const checkedCheckboxes = document.querySelectorAll('.idmsg input[type="checkbox"]:checked');
        const selectedValues = Array.from(checkedCheckboxes).map(checkbox => checkbox.id);

        const getStructureId = document.getElementById('templateSelect').value;

        $.ajax({
            url: '/make-it-blast/store-blast',
            method: 'POST',
            dataType: 'json',
            data: {
                blastName_data: blastName,
                contact_type_data: JSON.stringify(ctype),
                summernote_data: summernote,
                getStructureId: getStructureId,
                inputQuestion_data: inputQuestion,
                positionQuestion_data: positionQuestion,
                keywords_data: JSON.stringify(keywords),
                scheduleData_data: JSON.stringify(scheduleData),
                sendTo_data: JSON.stringify(selectedValues),
            },
            success: function(response) {
                console.log('response', response);
                if (response.status) {
                    showToast(response.message, 'success');
                } else {
                    let a = '';

                    if (response.message.blastName_data?.length) {
                        a += response.message.blastName_data[0] + '\n';
                    }
                    if (response.message.contact_type_data?.length) {
                        a += response.message.contact_type_data[0] + '\n';
                    }
                    if (response.message.sendTo_data?.length) {
                        a += 'Select Medium to send Blast is Required\n';
                    }
                    if (response.message.summernote_data?.length) {
                        a += 'Template Structure is required\n';
                    }

                    showToast(a.trim(), 'error');
                }
            },
            error: function() {
                showToast('Server error occurred!', 'error');
            }
        });
    });



    /*------------------------------------------------------------------------------------------------------------------------------------------*/
</script>
<form method="POST" action="{{url('/send-emails')}}">
    @csrf
    <input type="submit">
</form>
@stop