@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/user-account.css') }}">

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
<div class="error-messages">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div id="success-overlay">
    <div class="alert alert-success-message" id="popup-box">
        <button class="close-btn" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></button>
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

    <div class="info-frm">
        <form method="POST" class="per-info" action="{{url('user_meta')}}">
            @csrf

            <h2 class="mb-4">Update Personal Info</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company_name" value="{{ $userMetaData->company_name ?? '' }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">User Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="user_email" required value="{{ $userMetaData['pre_email'] ??'' }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" value="{{ $userMetaData->address ?? '' }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Zipcode</label>
                    <input type="text" class="form-control" name="zipcode" value="{{ $userMetaData->zipcode ?? '' }}">
                </div>
            </div>

   



            <!-- Contry state city  -->

            <div class="row g-3 mb-4">
                <!-- Country -->
                <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <select name="country" id="country" class="form-select" onchange="loadStates()">
                        <option value="">Select Country</option>
                    </select>
                </div>

                <!-- State -->
                <div class="col-md-4">
                    <label class="form-label">State</label>
                    <select name="state" id="state" class="form-select" onchange="loadCities()">
                        <option value="">Select State</option>
                    </select>
                </div>

                <!-- City -->
                <div class="col-md-4">
                    <label class="form-label">City</label>
                    <select id="city" class="form-select" name="city">
                        <option value="">Select City</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Billing Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="billing_email" value="{{ $userMetaData['pre_email'] ?? $userMetaData->email?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Billing Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="confirm_billing_email" value="{{ $userMetaData['pre_email'] ?? $userMetaData->email?? '' }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $userMetaData['pre_name'] ?? $userMetaData->first_name ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="{{ $userMetaData->last_name ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mobile Number</label>
                    <input type="number" class="form-control" name="phno" value="{{ $userMetaData['pre_phno'] ?? $userMetaData->phno ?? '' }}">
                </div>
            </div>

            <button type="submit" class="btn btn-outline-primary">Save Changes</button>
        </form>

        <div class="upload-container">
            @if(!empty($userMetaData->avatar))
            <img src="{{ asset('/usr_profile_images/' . $userMetaData->avatar) }}" alt="Profile Image" class="profile-avatar">
            @else
            <img src="{{ asset('/media/avatar.jpg') }}" alt="Default Profile Image" class="profile-avatar">
            @endif



            <div class="upload-label">
                <form method="POST" action="{{ url('upld-profile-image') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-container">

                        <input type="file" id="fileInput" name="avatar" accept="image/jpeg, image/jpg, image/png">
                    </div>
                    <input type="submit" value="Upload Profile Image">
                </form>


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
                    <div class="col-md-6">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="current_password">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="new_password_confirmation">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </form>
        </div>
    </div>
</div>

<script>

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

        // Close popup when clicking outside the message box
    document.addEventListener('click', function (event) {
        const overlay = document.getElementById('success-overlay');
        const popupBox = document.getElementById('popup-box');

        if (event.target === overlay) {
            closePopup();
        }
    });

    // Close popup function
    function closePopup() {
        document.getElementById('success-overlay').style.display = 'none';
    }
</script>

@stop