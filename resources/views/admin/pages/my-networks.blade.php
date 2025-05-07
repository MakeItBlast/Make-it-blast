@extends('admin.layout.app')
<link rel="stylesheet" href="{{ asset('styles/my-networks.css') }}">

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

    <div class="container">
        <h4 class="mb-3">Social Media Integration</h4>

        <div class="social">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Enabled</th>
                        <th>Digital Media Network</th>
                        <th>Media Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Google -->
                    <tr>
                        <td><input type="checkbox" checked></td>
                        <td>
                            <button class="login-btn"><i class="fab fa-google"></i> Log in with Google</button>
                        </td>
                        <td><span class="status-connected">Connected</span></td>
                        <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                    </tr>
                    <!-- Apple -->
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <button class="login-btn"><i class="fab fa-apple"></i> Log in with Apple</button>
                        </td>
                        <td><span class="status-disconnected">Dis-Connected</span></td>
                        <td><button class="btn btn-outline-dark btn-sm">Connect</button></td>
                    </tr>
                    <!-- Facebook -->
                    <tr>
                        <td><input type="checkbox" checked></td>
                        <td>
                            <button class="login-btn"><i class="fab fa-facebook"></i> Log in with Facebook</button>
                        </td>
                        <td><span class="status-connected">Connected</span></td>
                        <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                    </tr>
                    <!-- Twitter -->
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <button class="login-btn"><i class="fab fa-twitter"></i> Log in with Twitter</button>
                        </td>
                        <td><span class="status-connected">Connected</span></td>
                        <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                    </tr>
                    <!-- Instagram -->
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <button class="login-btn"><i class="fab fa-instagram"></i> Log in with Instagram</button>
                        </td>
                        <td><span class="status-disconnected">Dis-Connected</span></td>
                        <td><button class="btn btn-outline-dark btn-sm">Connect</button></td>
                    </tr>
                    <!-- TikTok -->
                    <tr>
                        <td><input type="checkbox" checked></td>
                        <td>
                            <button class="login-btn"><i class="fab fa-tiktok"></i> Log in with TikTok</button>
                        </td>
                        <td><span class="status-connected">Connected</span></td>
                        <td><button class="btn btn-outline-dark btn-sm">Dis-Connect</button></td>
                    </tr>
                </tbody>
            </table>
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
</script>

@stop