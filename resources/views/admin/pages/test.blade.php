@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/test.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    .table-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin: 30px auto;
    }

    .table-header {
        font-weight: 600;
        color: #333;
        font-size: 20px;
        margin-bottom: 15px;
    }

    table.dataTable {
        border-collapse: separate;
        border-spacing: 0 10px;
        width: 100%;
    }

    table.dataTable thead th {
        background: #f4f6f9;
        color: #555;
        border: none;
        font-weight: 600;
        padding: 15px;
    }

    table.dataTable tbody td {
        background: #ffffff;
        color: #333;
        border: none;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    table.dataTable tbody tr {
        transition: 0.3s;
    }

    table.dataTable tbody tr td {
        padding: 18px 20px;
        /* Adjust the padding as needed */
    }

    table.dataTable tbody tr:hover {
        background-color: #f1f1f1;
    }


    #example_filter {
        margin-bottom: 20px;
    }

    .bottom {
        margin-top: 20px;
    }

    #summernote{
        width:100%;
        height: 400px;
        padding:40px;
    }

    .toolbar{
        display:flex;
        justify-content: space-between;
    }
    .toolbar button {
        border: 1px solid #ccc;
        margin: 2px;
    }

    .editor-area {
        background-color: #fff;
        padding: 10px;
        font-family: Calibri, Arial, sans-serif;
    }
</style>

@section('content')
<!-- Display any errors if present -->
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
<div class="overlay" id="success-overlay">
    <div class="alert alert-success-message">
        <button class="close-btn" onclick="document.getElementById('success-overlay').style.display='none'"><i class="fa-solid fa-xmark"></i></button>
        <div class="icon-container">
            <img src="{{ asset('/media/login-success.gif') }}" class="d-block w-100">
        </div>
        <div class="message-content">
            <strong>Welcome back,</strong>
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

    <div class="container mt-5">
        <h3 class="mb-4">Select Location</h3>

        <form action="">
            <div class="row g-3">
                <!-- Country -->
                <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <select id="country" class="form-select" onchange="loadStates()">
                        <option value="">Select Country</option>
                    </select>
                </div>

                <!-- State -->
                <div class="col-md-4">
                    <label class="form-label">State</label>
                    <select id="state" class="form-select" onchange="loadCities()">
                        <option value="">Select State</option>
                    </select>
                </div>

                <!-- City -->
                <div class="col-md-4">
                    <label class="form-label">City</label>
                    <select id="city" class="form-select" name="city" value="{{ $userMetaData->city ?? '' }}">
                        <option value="">Select City</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

    </div>

    <div class="container mt-5">

        <div class="table-container">

            <table id="example" class="display table table-striped" style="width:100%">
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


        <div class="tab-bg">
            <div class="row mt-3">
                <!-- Credit Card Number -->
                <div class="col-md-4">
                    <input type="text"
                        class="form-control"
                        name="card_number"
                        placeholder="Credit Card"
                        maxlength="16"
                        pattern="[0-9]{13,16}"
                        title="Enter a valid 13 to 16-digit card number"
                        required>
                </div>

                <!-- Expiration Date -->
                <div class="col-md-4">
                    <input type="month"
                        class="form-control"
                        name="exp_date"
                        min="{{ date('Y-m') }}"
                        placeholder="Expiration Date"
                        required>
                </div>

                <!-- CVV -->
                <div class="col-md-4">
                    <input type="text"
                        class="form-control"
                        name="cvv"
                        placeholder="CVV"
                        maxlength="4"
                        pattern="[0-9]{3,4}"
                        title="Enter a valid 3 or 4-digit CVV"
                        required>
                </div>
            </div>

        </div>


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

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary">BACK</button>
                    <button type="button" class="btn btn-primary next-btn">NEXT</button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        <script>
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

            // for adding country state and cities dynamically
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


            // for datables

            $(document).ready(function() {
                $('#example').DataTable({
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "ordering": true,
                    "lengthChange": true,
                    "pageLength": 5,
                    "dom": '<"top"f>rt<"bottom"lp><"clear">',
                    "language": {
                        "search": "",
                        "searchPlaceholder": "Search table..."
                    }
                });
            });

            // for card form validation
            document.addEventListener("DOMContentLoaded", () => {
                const cardNumberInput = document.querySelector('input[name="card_number"]');
                const cvvInput = document.querySelector('input[name="cvv"]');

                // Prevent non-numeric input for card and CVV fields
                cardNumberInput.addEventListener('input', () => {
                    cardNumberInput.value = cardNumberInput.value.replace(/\D/g, '');
                });

                cvvInput.addEventListener('input', () => {
                    cvvInput.value = cvvInput.value.replace(/\D/g, '');
                });
            });
        </script>

        @stop