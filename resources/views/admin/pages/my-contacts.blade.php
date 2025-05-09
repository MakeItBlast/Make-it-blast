@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/my-contacts.css') }}">
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
    <div id="multiScreenContainer">
        <!-- Screen 1 - Matches Provided Layout -->
        <div class="screen active" id="screen1">

            <div class="tab-bg mb-4">
                <h2 class="mt-4 mb-4">Contact List</h2>
                <div class="table-responsive">
                    <table class="dataTable table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Contact Type</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Time Zone</th>
                                <th>SMS</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php use Illuminate\Support\Str; @endphp

                            @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $contact->contactType->id }}</td>
                                <td>{{ $contact->contactType->contact_type }}</td>
                                <td>{{ $contact->c_fname }}</td>
                                <td>{{ $contact->c_lname }}</td>
                                <td>{{ $contact->c_city }}</td>
                                <td>{{ $contact->c_state }}</td>
                                <td>{{ $contact->c_timezone }}</td>
                                <td>{{ $contact->c_phno }}</td>
                                <td title="{{ $contact->c_email }}">
                                    {{ Str::limit($contact->c_email, 12, '...') }}
                                </td>
                                <td class="action-btns">
                                    <a href="{{url('update-contact/'.$contact->id)}}" class="btn btn-sm btn-outline-primary edit-btn">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="{{url('delete-contact/'.$contact->id)}}" class="btn btn-sm btn-outline-danger delete-btn">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
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
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="10" class="text-center">No contacts available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>

            <!-- Search and Action Buttons -->
            <div class="tab-bg mb-4">
                <div class="d-flex justify-content-end gap-3">
                    <button class="btn btn-primary" onclick="document.getElementById('cncfrm').scrollIntoView({ behavior: 'smooth' });">
                        Create New
                    </button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
                </div>
            </div>


            <!-- Contact Information Form -->
            <div class="tab-bg" id="cncfrm">
                <form method="POST" action="{{url('add-contact')}}">
                    @csrf
                    <input type="hidden" name="updId" value="{{$updContact->id ?? ''}} ">
                    <h2 class="my-4">Edit/Create New Contact</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Contact Type</label>
                            <select class="form-select" name="c_contact_type">
                                <option>Select Contact Type</option>
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

                            <select id="country" class="form-select" name="c_country" onchange="loadStates()">
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
                        <div class="col-md-4">
                            @php
                            $timezones = timezone_identifiers_list();
                            @endphp

                            <label class="form-label">Time Zone</label>
                            <select name="c_timezone" class="form-control" required>
                                @foreach($timezones as $timezone)
                                @php
                                $dt = new DateTime("now", new DateTimeZone($timezone));
                                $offset = $dt->getOffset();
                                $hours = floor($offset / 3600);
                                $minutes = abs($offset % 3600) / 60;
                                $prefix = $offset < 0 ? '-' : '+' ;
                                    $gmtOffset='GMT' . $prefix . str_pad(abs($hours), 2, '0' , STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0' , STR_PAD_LEFT);
                                    @endphp
                                    <option value="{{ $timezone }}" {{ old('timezone', $updContact->timezone ?? '') == $timezone ? 'selected' : '' }}>
                                    {{ $gmtOffset }} - {{ $timezone }}
                                    </option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-3">

                        <button type="submit" class="btn btn-success">
                            {{ !empty($updContact) && !empty($updContact->id) ? 'Update' : 'Save' }}
                        </button>
                        @if(empty($updContact) || empty($updContact->id))
                        <button type="reset" class="btn btn-secondary">Clear</button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="tab-bg mt-4">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-danger">Failed Report</button>
                    <!-- <button class="btn btn-primary float-end" onclick="showScreen('screen2')">Next</button> -->
                </div>
            </div>


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
                        <table id="importcsv" class="dataTable table table-bordered text-center">
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
                        <table id="mappingCSV" class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>FILE HEADER</th>
                                    <th>DATA</th>
                                    <th>COMPANY ATTRIBUTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows inserted via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-bg">
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-dark px-4" onclick="showScreen('screen2')">Back</button>
                        <button type="button" class="btn btn-success px-4" id="mapDataBtn" onclick="showScreen('screen4')">Continue</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Screen 4 -->
        <div class="screen" id="screen4">

            <div class="tab-bg">

                <form method="POST" action="{{url('import-contact-list')}}">
                    @csrf
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
                    <div class="table-responsive">
                        <table id="finalstep" class="dataTable table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Contact Type</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Timezone</th>
                                    <th>SMS</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <!-- Contact Count -->
                    <div class="text-center my-3">
                        <p class="fw-bold">Total Contact Ready To Import = 2 out of 14</p>
                    </div>

                    <!-- Confirm & Cancel Buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" id="submitFinalData" class="btn btn-outline-dark px-4" href="#">I Confirm</button>
                        <button class="btn btn-outline-secondary px-4">Cancel</button>
                    </div>
            </div>
            </form>
            <button class="btn btn-secondary mt-3" onclick="showScreen('screen3')">Back</button>
        </div>
        <!-- Upload Contact File -->

    </div>
</div>

<!-- modal boxes -->

<!-- Bootstrap Modal for Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fs-5" id="importModalLabel">Upload Contact File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body pt-0 px-4">
                <form method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf

                    <!-- File Upload Box -->
                    <div class="mb-4">
                        <label for="fileInput" class="border-2 border-dashed rounded p-5 text-center w-100 d-block cursor-pointer" id="fileDropArea">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-primary"></i>
                            <p class="mb-1 fw-medium">Select your file or drop it here</p>
                            <small class="text-muted">Supported formats: .xls, .xlsx, .csv (Max: 250MB)</small>
                            <input type="file" name="file" id="fileInput" class="d-none" 
                                   accept=".xls, .xlsx, .csv" required>
                        </label>
                        
                        <!-- Simple File Display -->
                        <div id="fileDisplay" class="d-none mt-3">
                            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                                <span id="displayFileName" class="fw-medium"></span>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileBtn">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        </div>
                        
                        <div id="fileError" class="text-danger small mt-2 fw-medium d-none"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ asset('/media/Contact-Template.csv') }}" 
                           download="Contact-Template.csv" 
                           class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-download me-2"></i> Download Template
                        </a>

                        <button type="button" class="btn btn-primary px-4" id="submitBtn" 
                                data-bs-dismiss="modal" onclick="showScreen('screen2')" disabled>
                            Next
                        </button>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancel Import
                </button>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this contact?
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
<!-- For CSV parsing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script>
    // for screen 2 
    function showScreen(screenId) {
        // Hide all screens
        const screens = document.querySelectorAll('[id^="screen"]');
        screens.forEach(screen => screen.style.display = 'none');

        // Show the target screen
        const targetScreen = document.getElementById(screenId);
        if (targetScreen) {
            targetScreen.style.display = 'block';
        }
    }

    // NEW FOR MAPPING HEADERS 
    let csvDataRaw = []; // All CSV rows (including headers)
    let finalMappedData = []; // Final transformed rows to send to backend
    let headerToAttributeMap = {}; // Maps CSV header to selected attribute
    let failedRecords = []; // Store failed records

    const contactFieldOptions = [{
            value: "",
            label: "Do not import"
        },
        {
            value: "contact_type",
            label: "Contact Type"
        },
        {
            value: "c_fname",
            label: "First Name"
        },
        {
            value: "c_lname",
            label: "Last Name"
        },
        {
            value: "c_city",
            label: "City"
        },
        {
            value: "c_state",
            label: "State"
        },
        {
            value: "c_timezone",
            label: "Timezone"
        },
        {
            value: "c_phno",
            label: "Phone Number"
        },
        {
            value: "c_email",
            label: "Email"
        }
    ];

    $(document).ready(function() {
        $('#submitBtn').on('click', function() {
            const file = $('#fileInput')[0].files[0];
            if (!file) return showToast('Please upload a file first.', 'danger');

            const reader = new FileReader();
            reader.onload = function(e) {
                const contents = e.target.result.trim();

                // Normalize line endings, split into lines
                const lines = contents.replace(/\r\n/g, '\n').split('\n').filter(line => line.trim() !== '');

                if (lines.length < 2) return showToast('Not enough data.', 'danger');

                // Detect delimiter
                let delimiter = contents.includes(';') ? ';' : ',';

                csvDataRaw = lines.map(line => line.split(delimiter).map(val => val.replace(/^"|"$/g, '').trim()));

                const headers = csvDataRaw[0];
                const firstRow = csvDataRaw[1];

                const mappingTableBody = $('#mappingCSV tbody');
                mappingTableBody.empty();

                headers.forEach((header, i) => {
                    const row = `
                    <tr>
                        <td>${header}</td>
                        <td>${firstRow[i] || ''}</td>
                        <td>
                            <select class="form-select map-select" data-header="${header}" data-index="${i}">
                                ${createSelectBox('', [])}
                            </select>
                        </td>
                    </tr>`;
                    mappingTableBody.append(row);
                });

                let importTableBody = $('#importcsv tbody');
                importTableBody.empty();

                for (let j = 1; j < csvDataRaw.length; j++) {
                    let row = csvDataRaw[j];
                    if (row.length > 1) {
                        let dataRow = '<tr>';
                        for (let k = 0; k < headers.length; k++) {
                            dataRow += '<td>' + (row[k] || '') + '</td>';
                        }
                        dataRow += '</tr>';
                        importTableBody.append(dataRow);
                    }
                }

                showScreen('screen2');
            };

            reader.readAsText(file);
        });

        $('#mapDataBtn').on('click', function() {
            headerToAttributeMap = {};
            $('.map-select').each(function() {
                const header = $(this).data('header');
                const selectedAttr = $(this).val();
                if (selectedAttr) {
                    headerToAttributeMap[header] = selectedAttr;
                }
            });

            // Check if all mappings are completed when "mapDataBtn" is clicked
            let allMapped = true;
            $(".map-select").each(function() {
                if (!$(this).val()) {
                    allMapped = false;
                    return false; // Break the loop
                }
            });

            if (!allMapped) {
                // Show a toast when the user clicks the "mapDataBtn" and mappings are incomplete
                return showToast('Please map all columns before proceeding.', 'danger');
            }

            const headers = csvDataRaw[0];
            finalMappedData = [];

            for (let i = 1; i < csvDataRaw.length; i++) {
                const row = csvDataRaw[i];
                if (row.length === 0 || row.every(col => col === '')) continue;

                let mappedRow = {};
                headers.forEach((header, index) => {
                    const attrKey = headerToAttributeMap[header];
                    if (attrKey) {
                        mappedRow[attrKey] = row[index] || '';
                    }
                });
                finalMappedData.push(mappedRow);
            }

            const finalTable = $('#finalstep');
            finalTable.empty();

            const allAttributes = Object.values(headerToAttributeMap);
            let thead = '<thead><tr>';
            allAttributes.forEach(attr => {
                thead += `<th>${attr}</th>`;
            });
            thead += '</tr></thead>';

            let tbody = '<tbody>';
            finalMappedData.forEach(row => {
                tbody += '<tr>';
                allAttributes.forEach(attr => {
                    tbody += `<td>${row[attr] || ''}</td>`;
                });
                tbody += '</tr>';
            });
            tbody += '</tbody>';

            finalTable.append(thead + tbody);

            showScreen('screen4');
        });

        $('#submitFinalData').on('click', function(e) {
            e.preventDefault();

            if (finalMappedData.length === 0) {
                return showToast('No mapped data found.', 'danger');
            }

            $.ajax({
                url: '/make-it-blast/import-contact-list',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({
                    data: finalMappedData
                }),
                success: function(response) {
                    const toastEl = document.getElementById('ajaxToast');
                    const toastBody = toastEl.querySelector('.toast-body');
                    if (response.success) {
                        toastBody.textContent = 'Data Imported Successfully!';
                        toastEl.classList.remove('text-bg-danger');
                        toastEl.classList.add('text-bg-success');
                    } else {
                        toastBody.textContent = `Error: ${response.message}`;
                        toastEl.classList.remove('text-bg-success');
                        toastEl.classList.add('text-bg-danger');
                    }
                    new bootstrap.Toast(toastEl).show();
                },
                error: function(xhr, status, error) {
                    const toastEl = document.getElementById('ajaxToast');
                    const toastBody = toastEl.querySelector('.toast-body');

                    let errorMessage = 'Server error occurred!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        errorMessage = xhr.responseText;
                    } else if (error) {
                        errorMessage = error;
                    }

                    toastBody.textContent = errorMessage;
                    toastEl.classList.remove('text-bg-success');
                    toastEl.classList.add('text-bg-danger');
                    new bootstrap.Toast(toastEl).show();
                }
            });
        });

        // Dropdown mapping logic
        $(document).on('change', '.map-select', function() {
            updateAllDropdowns();
            checkMappings(); // Ensure mapping validation is checked when dropdown changes
        });

        // Function to validate mapping completion
        function checkMappings() {
            let allMapped = true;
            $(".map-select").each(function() {
                if (!$(this).val()) {
                    allMapped = false;
                    return false; // Break the loop
                }
            });

            if (allMapped) {
                $('#mapDataBtn').prop('disabled', false); // Enable the "Proceed" button
            } else {
                $('#mapDataBtn').prop('disabled', true); // Disable the "Proceed" button
            }
        }

        // Initial check when the page loads
        checkMappings();

        function updateAllDropdowns() {
            let selectedValues = [];

            $('.map-select').each(function() {
                const val = $(this).val();
                if (val) selectedValues.push(val);
            });

            $('.map-select').each(function() {
                const currentVal = $(this).val();
                const index = $(this).data('index');
                const dropdownHtml = createSelectBox(currentVal, selectedValues.filter(v => v !== currentVal));
                $(this).html(dropdownHtml);
                $(this).val(currentVal);
            });
        }

        function showToast(message, type) {
            const toastEl = document.getElementById('ajaxToast');
            const toastBody = toastEl.querySelector('.toast-body');
            toastBody.textContent = message;
            toastEl.classList.remove('text-bg-danger', 'text-bg-success');
            toastEl.classList.add(`text-bg-${type}`);
            new bootstrap.Toast(toastEl).show();
        }
    });

    function createSelectBox(selectedValue, excludeValues) {
        return contactFieldOptions.map(opt => {
            const disabled = excludeValues.includes(opt.value) ? 'disabled' : '';
            const selected = selectedValue === opt.value ? 'selected' : '';
            return `<option value="${opt.value}" ${disabled} ${selected}>${opt.label}</option>`;
        }).join('');
    }


    function showScreen(screenId) {
        $('.screen').hide();
        $('#' + screenId).show();
    }


    // END
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

    // for import modal 
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const fileDisplay = document.getElementById('fileDisplay');
        const displayFileName = document.getElementById('displayFileName');
        const removeFileBtn = document.getElementById('removeFileBtn');
        const fileError = document.getElementById('fileError');
        const submitBtn = document.getElementById('submitBtn');
        
        // Handle file selection
        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                const file = this.files[0];
                
                // Basic validation
                const validExtensions = ['.xls', '.xlsx', '.csv'];
                const fileExt = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                const maxSize = 250 * 1024 * 1024; // 250MB
                
                if (!validExtensions.includes(fileExt)) {
                    showError('Invalid file type. Please upload .xls, .xlsx, or .csv files.');
                    return;
                }
                
                if (file.size > maxSize) {
                    showError('File size exceeds 250MB limit');
                    return;
                }
                
                // Display file name
                displayFileName.textContent = file.name;
                fileDisplay.classList.remove('d-none');
                submitBtn.disabled = false;
            }
        });
        
        // Remove file handler
        removeFileBtn.addEventListener('click', function() {
            fileInput.value = '';
            fileDisplay.classList.add('d-none');
            submitBtn.disabled = true;
            fileError.classList.add('d-none');
        });
        
        function showError(message) {
            fileError.textContent = message;
            fileError.classList.remove('d-none');
            fileInput.value = '';
            setTimeout(() => fileError.classList.add('d-none'), 5000);
        }
    });
</script>

@stop