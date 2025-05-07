@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/user-account.css') }}">

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

        <div class="info-frm">
            <form method="POST" class="per-info">
                @csrf

                <h2 class="mb-4">Update Personal Info</h2>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_name" value="{{ $userMetaData->company_name ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">User Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="user_email" required value="{{ $pre_email ?? '' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $userMetaData->address ?? '' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ $userMetaData->city ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <select class="form-select" name="state">
                            <option value="1">State 1</option>
                            <option value="2">State 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Zipcode</label>
                        <input type="text" class="form-control" name="zipcode" value="{{ $userMetaData->zipcode ?? '' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Billing Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="billing_email" value="{{ $pre_email ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Billing Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="confirm_billing_email" value="{{ $pre_email ?? '' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="{{ $userMetaData->first_name ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="{{ $userMetaData->last_name ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" name="phno" value="{{ $userMetaData->phno ?? '' }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary">Save Changes</button>
            </form>

            <div class="upload-container">
                <img src="{{ asset('/media/avatar.jpg') }}" alt="Profile Image" id="preview">

                <div class="upload-label">
                    <button class="upload-btn">
                        <i class="fas fa-upload"></i> Upload
                        <input type="file" id="fileInput" accept="image/jpeg, image/jpg">
                    </button>
                </div>
            </div>
        </div>




        <hr class="mt-4">
        <div class="chng-pass-frm">
            <h2>Change Password</h2>
            <div class="mt-4 mb-4">
                <form>

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




@stop