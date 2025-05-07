@php

$user = Auth::user();
use Illuminate\Support\Facades\Auth;
@endphp

@if (!Auth::check())
<script>
    window.location = "/"; // Redirect to the home page
</script>
@endif

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">

        <!-- Sidebar Toggle -->
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-secondary me-3" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Navbar Actions -->
        <div class="d-flex align-items-center ms-auto">
            <a href="{{ url('create-blast') }}" class="btn btn-primary me-3">New Project</a>

            <!-- User Profile -->
            <div class="dropdown">
                <img src="{{ asset('/media/avatar.jpg') }}" alt="User" id="userImg" class="rounded-circle" 
                     style="width: 40px; height: 40px; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userImg">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li>
                        <form action="{{ url('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>
