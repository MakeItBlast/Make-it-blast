@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/my-templates.css') }}">
@stop

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

    <!-- Display template list here -->
    <div class="tab-bg">

        <div class="cont">

            <!-- Template Selection Form -->
            <div id="temp">
                <div class="form-group">
                    <div class="d-flex">
                        <form method="post" action="{{ url('select-template') }}" style="width:350px;">
                            @csrf
                            <label for="template" class="me-2">Select Template</label>
                            <div class="d-flex">
                                <select id="template" name="template" class="form-select" required>
                                    <option value="">Select Template</option>
                                    @foreach($tempelateList as $template)
                                    @if($template->status === 'active')
                                    <option value="{{ $template->id }}">{{ $template->temp_name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary go-btn">Go</button>
                            </div>
                        </form>
                    </div>

                    <!-- Trigger Button -->
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#resourceModal">
                        <span>Add Link or Media</span>
                    </button>
                    <button class="btn btn-primary mt-3" onclick="showHiddenDiv()">Create New</button>
                </div>
            </div>



            <!-- Edit Template Section -->
            @if(isset($getTempelateStructure->template_structure))
            <form class="my-4" action="{{ route('update-template-new') }}" method="POST" id="update-template-form">
                @csrf
                <div id="update-template">
                    <!-- Resource Select Boxes -->
                    @if(isset($links) || isset($medias))
                    <div class="d-flex gap-5 mt-3">
                        @if(isset($links))
                        <select class="form-select" onchange="insertIntoEditor(this)">
                            <option value="">Select Link</option>
                            @foreach($links as $link)
                            <option value="{{ $link->rsrc_value }}">{{ $link->rsrc_name }}</option>
                            @endforeach
                        </select>
                        @endif

                        @if(isset($medias))
                        <select class="form-select" onchange="insertIntoEditor(this)">
                            <option value="">Select Media</option>
                            @foreach($medias as $media)
                            <option value="{{ url('public/' . $media->rsrc_value) }}">{{ $media->rsrc_name }}</option>
                            @endforeach
                        </select>
                        @endif

                        <!-- Static Data Fields Dropdown -->
                        <select class="form-select" onchange="insertIntoEditor(this)">
                            <option value="">Select Data Field</option>
                            <option value="c_fname">First Name</option>
                            <option value="c_lname">Last Name</option>
                            <option value="c_email">Email</option>
                        </select>
                    </div>
                    @endif
                    <input type="hidden" id="template_id" name="template_id" value="{{ $getTempelateStructure->id ?? '' }}">
                    <div class="my-3">
                        <label class="me-2">Template Name</label>
                        <input type="text" class="form-control" id="edit_template_name" name="temp_name" required>
                    </div>
                    <div class="head mb-3">
                        <label class="form-label"><strong>(BLAST NAME)</strong> Message Editor</label>
                        <textarea class="form-control" name="template_structure" id="editSummernote" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Update Template</button>
                </div>
            </form>
            @endif

            <!-- Create New Template Section -->
            <form id="AddTemplate" method="POST" action="{{ url('add-template') }}">
                @csrf
                <div id="hidden-div" style="display:none;">

                    <!-- Resource Select Boxes -->
                    @if(isset($links) || isset($medias))
                    <div class="d-flex gap-5 mt-3">
                        @if(isset($links))
                        <select class="form-select" onchange="insertthisIntoEditor(this)">
                            <option value="">Select Link</option>
                            @foreach($links as $link)
                            <option value="{{ $link->rsrc_value }}">{{ $link->rsrc_name }}</option>
                            @endforeach
                        </select>
                        @endif

                        @if(isset($medias))
                        <select class="form-select" onchange="insertthisIntoEditor(this)">
                            <option value="">Select Media</option>
                            @foreach($medias as $media)
                            <option value="{{ $media->rsrc_value }}">{{ $media->rsrc_name }}</option>
                            @endforeach
                        </select>
                        @endif

                        <!-- Static Data Fields Dropdown -->
                        <select class="form-select" onchange="insertthisIntoEditor(this)">
                            <option value="">Select Data Field</option>
                            <option value="c_fname">First Name</option>
                            <option value="c_lname">Last Name</option>
                            <option value="c_email">Email</option>
                        </select>
                    </div>
                    @endif
                    <input type="hidden" name="tempelate_by" value="user" required>
                    <div class="my-3">
                        <label class="me-2">Template Name</label>
                        <input type="text" class="form-control" name="temp_name" id="new_template_name" placeholder="Please Enter Template Name" required>
                    </div>
                    <div class="head mb-3">
                        <label class="form-label"><strong>(BLAST NAME)</strong> Message Editor</label>
                        <textarea class="form-control" name="template_structure" id="newSummernote" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Save Template</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Saved Templates List -->
    <div class="tab-bg my-4">
        <h2 class="my-3">Saved Templates List</h2>
        <div class="table-responsive">
            <table class="dataTable table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Sr No</th>
                        <th>Template Name</th>
                        <th>Template Structure</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tempelateList as $index => $template)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $template->temp_name }}</td>
                        <td>{{ Str::limit(strip_tags($template->template_structure), 50) }}</td>
                        <td>
                            <form action="{{ url('delete-template', $template->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @php
                                $statusLower = strtolower($template->status);
                                @endphp
                                <button type="submit" class="btn btn-sm {{ $statusLower === 'active' ? 'btn-success' : 'btn-danger' }}">
                                    {{ ucfirst($statusLower) }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Links table  -->
    <div class="tab-bg my-4">

        <h3>Active Link List</h3>

        <div class="table-responsive">
            <table id="linkTable" class="dataTable table table-bordered" style="width:100%;">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>Link Text</th>
                        <th>Link URL</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($links) && count($links) > 0)
                    @foreach($links as $index => $link)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $link->rsrc_name ?? 'N/A' }}</td>
                        <td class="link-val">{{ $link->rsrc_value ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($link->created_at)->format('d/m/Y') ?? 'N/A' }}</td>
                        <td>
                        <button
                                class="btn btn-danger delete-btn"
                                data-id="{{ $link->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <!-- Dummy row to prevent DataTables column mismatch -->
                    <tr class="d-none">
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">No Links added yet</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    <!-- Media Table -->
    <div class="tab-bg my-4">

        <h3>Active Media List</h3>

        <div class="table-responsive">
            <table id="mediaTable" class="dataTable table table-bordered" style="width:100%;">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>Media Text</th>
                        <th>Media File</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($medias) && count($medias) > 0)
                    @foreach($medias as $index => $media)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $media->rsrc_name ?? 'N/A' }}</td>
                        <td>
                            @if(!empty($media->rsrc_value))
                            <button class="btn btn-sm btn-primary preview-button"
                                data-image="{{ asset($media->rsrc_value) }}" data-lightbox="media-{{ $index }}" data-title="{{ $media->rsrc_name }}">
                                <i class="fa-solid fa-magnifying-glass"></i> <span>View attachment</span>
                            </button>
                            @else
                            No Image
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($media->created_at)->format('d/m/Y') ?? 'N/A' }}</td>
                        <td>
                            <button
                                class="btn btn-danger delete-btn"
                                data-id="{{ $media->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="d-none">
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-center">No Media added yet</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>

    </div>

</div>


<!-- Add media modal -->
<div class="modal fade" id="resourceModal" tabindex="-1" aria-labelledby="resourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
            <div class="modal-header border-0 my-2">
                <h2 class="modal-title" id="resourceModalLabel">Add Resource</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0">
                <div class="row g-4">

                    <!-- Add Link Card -->
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-3">
                            <h5 class="mb-3">Add a URL Link</h5>
                            <form id="linkForm" method="POST" action="{{ url('store-link') }}">
                                @csrf
                                <div id="linkSuccessMsg" class="alert alert-success d-none">Link added successfully!</div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="url_text" placeholder="Text">
                                    <label>Link Text</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="url" class="form-control" name="url_value" placeholder="https://example.com">
                                    <label>Link URL</label>
                                </div>

                                <button type="button" class="btn btn-success w-100" onclick="submitLinkForm()">
                                    <i class="fa fa-link me-2"></i>Add Link
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Upload Media Card -->
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-3">
                            <h5 class="mb-3">Upload Image</h5>
                            <form id="mediaForm" method="POST" action="{{ url('store-media') }}" enctype="multipart/form-data">
                                @csrf
                                <div id="mediaSuccessMsg" class="alert alert-success d-none">Media uploaded successfully!</div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="media_text" id="media_text" placeholder="Image Name" required>
                                    <label>Media Name</label>
                                </div>

                                <label class="form-label fw-semibold">Choose Image (JPG, JPEG, PNG)<span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <label for="media_file" class="btn btn-outline-dark d-flex align-items-center gap-2 px-3">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> Browse
                                    </label>
                                    <input type="file" name="media_file" class="d-none" id="media_file" accept="image/jpeg,image/jpg,image/png" onchange="displayMediaFile()" required>
                                    <span class="text-truncate" id="fileName" style="max-width: 150px;">No file chosen</span>
                                    <button type="button" class="btn btn-outline-danger ms-2 rounded-circle" onclick="removeMediaFile()" style="display: none;" id="removeButton">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                <button type="button" class="btn btn-primary w-100 mt-3" onclick="submitMediaForm()">
                                    <i class="fa fa-upload me-2"></i>Upload
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal for media -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" id="deleteForm">
            @csrf
            <input type="hidden" name="delId" id="hiddenMediaId">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!--  Image preview modal from table  -->
<div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox()">
    <span class="lightbox-close"><i class="fa-solid fa-xmark"></i></span>
    <img class="lightbox-content" id="lightboxImg">
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS (needed for toast) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



<script>
    // for adding links and images to editsummernote 
    function insertIntoEditor(selectEl) {
        const value = selectEl.value;
        const text = selectEl.options[selectEl.selectedIndex].text;

        if (!value) return;

        let node;
        const isImage = value.match(/\.(jpeg|jpg|gif|png|webp|svg)$/i);
        const isURL = value.startsWith("http") || value.includes(".");
        const isDataField = ['First Name', 'Last Name', 'Emai'].includes(value);

        if (isImage) {
            node = document.createElement("img");
            node.src = value;
            node.alt = `[${text}]`;
            node.style.maxWidth = "100%";
        } else if (isDataField) {
            node = document.createTextNode(`[[ ${value} ]]`); // safe version for Blade
        } else {
            node = document.createElement("a");
            node.href = value;
            node.target = "_blank";
            node.innerText = `[${text}]`;
        }

        const br = document.createElement("br");

        $('#editSummernote').summernote('editor.insertNode', node);
        $('#editSummernote').summernote('editor.insertNode', br);

        selectEl.selectedIndex = 0;
    }


    // for adding links and images to newsummernote 
    function insertthisIntoEditor(selectEl) {
        const value = selectEl.value;
        const text = selectEl.options[selectEl.selectedIndex].text;

        if (!value) return;

        let node;

        if (value.match(/\.(jpeg|jpg|gif|png|webp|svg)$/i)) {
            node = document.createElement("img");
            node.src = value;
            node.alt = `[${text}]`; // optional alt text with brackets
            node.style.maxWidth = "100%";
        } else {
            node = document.createElement("a");
            node.href = value;
            node.target = "_blank";
            node.innerText = `[${text}]`; // <-- brackets added here
        }

        const br = document.createElement("br");

        $('#newSummernote').summernote('editor.insertNode', node);
        $('#newSummernote').summernote('editor.insertNode', br);

        selectEl.selectedIndex = 0;
    }

    // for media and links 

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
                const toastEl = document.getElementById('ajaxToast');
                const toastBody = toastEl.querySelector('.toast-body');

                // Update message and color
                if (response.status) {
                    $('#linkForm')[0].reset();
                    toastBody.textContent = 'Link added successfully!';
                    toastEl.classList.remove('text-bg-danger');
                    toastEl.classList.add('text-bg-success');
                } else {
                    toastBody.textContent = 'Something went wrong!';
                    toastEl.classList.remove('text-bg-success');
                    toastEl.classList.add('text-bg-danger');
                }

                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            },
            error: function() {
                const toastEl = document.getElementById('ajaxToast');
                const toastBody = toastEl.querySelector('.toast-body');
                toastBody.textContent = 'Server error occurred!';
                toastEl.classList.remove('text-bg-success');
                toastEl.classList.add('text-bg-danger');
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    }

    function submitMediaForm() {
        const form = document.getElementById('mediaForm');
        const formData = new FormData(form);

        $.ajax({
            url: '{{ url("store-media") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const toastEl = document.getElementById('ajaxToast');
                const toastBody = toastEl.querySelector('.toast-body');
                const bsToast = new bootstrap.Toast(toastEl);

                if (response.status) {
                    $('#mediaForm')[0].reset();
                    $('#fileName').text('No file chosen');
                    $('#removeButton').hide();

                    toastEl.classList.remove('text-bg-danger');
                    toastEl.classList.add('text-bg-success');
                    toastBody.textContent = 'Media uploaded successfully!';
                } else {
                    toastEl.classList.remove('text-bg-success');
                    toastEl.classList.add('text-bg-danger');
                    toastBody.textContent = 'Something went wrong!';
                }

                bsToast.show();
            },
            error: function(xhr) {
                const toastEl = document.getElementById('ajaxToast');
                const toastBody = toastEl.querySelector('.toast-body');
                const bsToast = new bootstrap.Toast(toastEl);

                toastEl.classList.remove('text-bg-success');
                toastEl.classList.add('text-bg-danger');
                toastBody.textContent = 'Upload failed. Please try again.';

                bsToast.show();
            }
        });
    }



    // for data tables
    $.fn.dataTable.ext.errMode = 'none';
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

    // function to show summernote 
    function showHiddenDiv() {
        document.getElementById('hidden-div').style.display = 'block';
        document.getElementById('template').value = '';


    }
    $(document).ready(function() {
        // Destroy Summernote instance before initializing (if already exists)

        if ($('#newSummernote').hasClass('note-editor')) {
            $('#newSummernote').summernote('destroy');
        }

        // Initialize Summernote Editors
        $('#editSummernote').summernote({
            height: 300,
            placeholder: 'Edit your template here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ]

        });

        $('#newSummernote').summernote({
            height: 300,
            placeholder: 'Write your message here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ]
        });
        // Show Create New Template Section
        window.showHiddenDiv = function() {
            $('#hidden-div').show();
            $('#update-template').hide();
            $('#newSummernote').summernote('code', '');
            $('#new_template_name').val('');
        };
        // Check if selected template data is available and load it into the editor
        @if(isset($getTempelateStructure))
        console.log("Populating Summernote with template data...");
        $('#editSummernote').summernote('code', `{!! addslashes($getTempelateStructure->template_structure) !!}`);
        $('#edit_template_name').val("{{ $getTempelateStructure->temp_name }}");
        $('#template_id').val("{{ $getTempelateStructure->id }}");
        $('#update-template').show();
        $('#hidden-div').hide();
        @endif
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


    // For image in blast

    function displayMediaFile() {
        const input = document.getElementById('media_file');
        const fileName = document.getElementById('fileName');
        const removeButton = document.getElementById('removeButton');

        if (input.files.length > 0) {
            fileName.textContent = input.files[0].name;
            removeButton.style.display = 'inline-block';
        } else {
            fileName.textContent = 'No file chosen';
            removeButton.style.display = 'none';
        }
    }

    function removeMediaFile() {
        const input = document.getElementById('media_file');
        const fileName = document.getElementById('fileName');
        const removeButton = document.getElementById('removeButton');

        input.value = "";
        fileName.textContent = 'No file chosen';
        removeButton.style.display = 'none';
    }

    document.querySelectorAll('.preview-button').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = document.getElementById('lightboxModal');
            const modalImg = document.getElementById('lightboxImg');
            modal.style.display = 'block';
            modalImg.src = this.getAttribute('data-image');
        });
    });

    function closeLightbox() {
        document.getElementById('lightboxModal').style.display = 'none';
    }


    // for delete 
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const mediaId = button.getAttribute('data-id');

        // Set hidden input value
        document.getElementById('hiddenMediaId').value = mediaId;

        // Use a generic action URL
        deleteForm.action = `/make-it-blast/delete-resource`;
    });
</script>
@stop