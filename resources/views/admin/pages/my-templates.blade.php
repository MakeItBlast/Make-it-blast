@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/my-templates.css') }}">

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
        <button class="close-btn" onclick="document.getElementById('success-overlay').style.display='none'">
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
<div class="main-cont my-4 py-4">
    <div class="cont">
        <!-- Template Selection Form -->
        <div id="temp">
            <div class="form-group">
                <div class="d-flex">
                    <form method="post" action="{{ url('select-template') }}" class="d-flex gap-3">
                        @csrf
                        <!-- Select Dropdown with Label -->
                        <label for="template" class="me-2">Select Template</label>
                        <select id="template" name="template" class="form-select">
                            <option value="">Select Template</option>
                            @foreach($tempelateList as $template)
                            <option value="{{ $template->id }}">{{ $template->temp_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-outline-primary go-btn">Go</button>
                    </form>
                </div>
                <!-- Create New Button -->
                <button class="btn btn-primary mt-3" onclick="showHiddenDiv()">Create New</button>
            </div>
        </div>

        <!-- Edit Template Section -->
        <form method="POST" action="{{ url('update-template') }}">
            @csrf
            <div id="update-template" style="margin-top: 20px; padding: 15px; border: 1px solid #ccc;">
                <input type="hidden" id="template_id" name="template_id" value="{{$getTempelateStructure->id ?? ''}}">

                <div class="row w-auto">
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

        <!-- Create New Template Section -->
        <form id="AddTemplate" method="POST" action="{{ url('add-template') }}">
            @csrf
            <div id="hidden-div" style="margin-top: 20px; padding: 15px; border: 1px solid #ccc;">
                <input type="hidden" name="template_by" value="user" required>

                <div class="row w-auto">
                    <label class="me-2">Template Name</label>
                    <input type="text" name="temp_name" id="new_template_name" placeholder="Please Enter Template Name" required>
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

<script>
   

    function showHiddenDiv() {
        document.getElementById('hidden-div').style.display = 'block';
    }

    $(document).ready(function() {
        // Destroy Summernote instance before initializing (if already exists)
        if ($('#editSummernote').hasClass('note-editor')) {
            $('#editSummernote').summernote('destroy');
        }

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

        $('#newSummernote').summernote({
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

    // Custom button definitions
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
</script>
@stop