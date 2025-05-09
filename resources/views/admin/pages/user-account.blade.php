@extends('admin.layout.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/user-account.css') }}">
@stop


@php
use Illuminate\Support\Facades\Auth;
@endphp

@if (!Auth::check())
<script>
    window.location = "/"; // Redirect to the home page
</script>
@endif

@section('content')
<!-- Display any errors if present -->
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
        <div class="icon-container">
            <img src="{{ asset('/media/login-success.gif') }}" class="d-block w-100">
        </div>
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

    <div class="info-frm">
        <form method="POST" class="per-info" action="{{url('user_meta')}}">
            @csrf

            <h2 class="mb-4">Update Personal Info</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company_name" value="{{ old('company_name') ?? $userMetaData->company_name ?? '' }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">User Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" required value="{{ old('user_email') ?? $userMetaData['pre_email'] ??'' }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Address<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" value="{{ old('address') ?? $userMetaData->address ?? '' }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Zipcode<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="zipcode" value="{{ old('zipcode') ?? $userMetaData->zipcode ?? '' }}">
                </div>
            </div>





            <!-- Contry state city  -->

            <div class="row g-3 mb-4">
                <!-- Country -->
                <div class="col-md-4">
                    <label class="form-label">Country<span class="text-danger">*</span></label>
                    <select name="country" id="country" class="form-select" onchange="loadStates()" required>
                        <option value="">Select Country</option>
                    </select>
                </div>

                <!-- State -->
                <div class="col-md-4">
                    <label class="form-label">State<span class="text-danger">*</span></label>
                    <select name="state" id="state" class="form-select" onchange="loadCities()" required>
                        <option value="">Select State</option>
                    </select>
                </div>

                <!-- City -->
                <div class="col-md-4">
                    <label class="form-label">City<span class="text-danger">*</span></label>
                    <select id="city" class="form-select" name="city" required>
                        <option value="">Select City</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Billing Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="billing_email" value="{{ $userMetaData['pre_email'] ? $userMetaData['pre_email']   : $userMetaData->billing_email}}" >
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Billing Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="billing_email_confirmation" value="{{ $userMetaData['pre_email'] ? $userMetaData['pre_email']   : $userMetaData->billing_email}}" >
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">First Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" value="{{$userMetaData['pre_name'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ?? $userMetaData['pre_last'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mobile Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phno" id="phno"
                        value="{{ $userMetaData['pre_phno'] ?? '' }}" maxlength="14" placeholder="(123) 456-7890">
                    <div class="invalid-feedback" id="phno-error" style="display: none;">Phone number must be 10 digits</div>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-primary">Save Changes</button>
        </form>

        <div class="upload-container">
            @php
            $profileImage = !empty($userMetaData->avatar)
            ? asset('/usr_profile_images/' . $userMetaData->avatar)
            : asset('/media/avatar.jpg');
            @endphp

            <!-- Clickable Image Wrapper -->
            <label for="fileInput" class="image-upload-wrapper">
                <img id="profileImage" src="{{ $profileImage }}" alt="Profile Image" class="profile-avatar">
                <div class="image-overlay">
                    <i class="fa-solid fa-camera"></i>
                    <span>Change Photo</span>
                </div>
            </label>

            <div class="upload-label">
                <form method="POST" action="{{ url('upld-profile-image') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden file input -->
                    <input type="file" class="custom-file-input" id="fileInput" name="avatar" accept="image/jpeg,image/jpg,image/png" style="display: none;" required>

                    <button type="submit" class="my-2 btn btn-sm btn-success" id="upd-img">
                        <i class="fa-solid fa-upload me-2"></i>Upload Image
                    </button>
                </form>

                <a class="btn btn-sm btn-danger dlt-acc my-2" href="{{ url('delete-account') }}">
                    <i class="fa-solid fa-trash-can"></i><span class="mx-2">Delete Account</span>
                </a>
            </div>
        </div>


    </div>




    <hr class="mt-4">
    <div class="chng-pass-frm">
        <h2>Change Password</h2>
        <div class="mt-4 mb-4">
            <form method="POST" action="{{url('forget-password')}}">

                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 input-field">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="current_password" id="passwordInput">
                        <span class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; cursor: pointer;">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 input-field">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="new_password" id="passwordInput">
                        <span class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; cursor: pointer;">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </div>
                    <div class="col-md-6 input-field">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="new_password_confirmation" id="passwordInput">
                        <span class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; cursor: pointer;">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </form>
        </div>
    </div>
</div>



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


    // For phone number field 
    document.addEventListener('DOMContentLoaded', function() {
        const phnoInput = document.getElementById('phno');
        const phnoError = document.getElementById('phno-error');

        // Format as (xxx) xxx-xxxx
        phnoInput.addEventListener('input', function(e) {
            let cleaned = phnoInput.value.replace(/\D/g, '').slice(0, 10);
            let formatted = '';

            if (cleaned.length > 0) {
                formatted += '(' + cleaned.slice(0, 3);
            }
            if (cleaned.length >= 4) {
                formatted += ') ' + cleaned.slice(3, 6);
            }
            if (cleaned.length >= 7) {
                formatted += '-' + cleaned.slice(6, 10);
            }

            phnoInput.value = formatted;
        });

        // Validate on form submit
        phnoInput.form.addEventListener('submit', function(e) {
            const rawNumber = phnoInput.value.replace(/\D/g, '');
            if (rawNumber.length !== 10) {
                e.preventDefault();
                phnoInput.classList.add('is-invalid');
                phnoError.style.display = 'block';
            } else {
                phnoInput.classList.remove('is-invalid');
                phnoError.style.display = 'none';
            }
        });
    });

    //for password toggle 
    function togglePassword() {
            const passwordInput = document.getElementById("passwordInput");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }


    // These come from the server-side Blade template
    const selectedCountry = @json($userMetaData -> country ?? null);
    const selectedState = @json($userMetaData -> state ?? null);
    const selectedCity = @json($userMetaData -> city ?? null);

    document.addEventListener("DOMContentLoaded", () => {
        loadCountries();
    });

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
                    if (country.country === selectedCountry) {
                        option.selected = true;
                    }
                    countryDropdown.appendChild(option);
                });

                if (selectedCountry) {
                    loadStates(selectedCountry); // Pass selected country for states
                }
            })
            .catch(error => console.error("Error loading countries:", error));
    }

    function loadStates(preloadCountry = null) {
        const country = preloadCountry || document.getElementById("country").value;
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
                        country
                    })
                })
                .then(response => response.json())
                .then(data => {
                    data.data.states.forEach(state => {
                        const option = document.createElement("option");
                        option.value = state.name;
                        option.textContent = state.name;
                        if (state.name === selectedState) {
                            option.selected = true;
                        }
                        stateDropdown.appendChild(option);
                    });

                    if (selectedState) {
                        loadCities(country, selectedState);
                    }
                })
                .catch(error => console.error("Error loading states:", error));
        }
    }

    function loadCities(preloadCountry = null, preloadState = null) {
        const country = preloadCountry || document.getElementById("country").value;
        const state = preloadState || document.getElementById("state").value;
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
                        if (city === selectedCity) {
                            option.selected = true;
                        }
                        cityDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error("Error loading cities:", error));
        }
    }

    // Event handlers
    document.getElementById("country").addEventListener("change", () => {
        loadStates(); // no preload — just based on selection
    });

    document.getElementById("state").addEventListener("change", () => {
        loadCities(); // no preload — just based on selection
    });


    // For image Preview 
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('fileInput');
        const profileImage = document.getElementById('profileImage');

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    profileImage.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });
    });

    // profile photo upload 
    const fileInput = document.getElementById('fileInput');
    const preview = document.getElementById('preview');

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@stop