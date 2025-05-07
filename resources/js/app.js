// Import Summernote and Dependencies
import 'bootstrap';
import $ from 'jquery';
import 'summernote/dist/summernote-bs4.min';

// Initialize Summernote
$(document).ready(function() {
    $('.summernote').summernote({
        height: 500, // Adjust height as needed
        placeholder: 'Type your content here...',
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});

