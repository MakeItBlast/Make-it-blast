@php
use App\Models\User;

$c_id = auth()->id();
$user = user::find($c_id);
@endphp

<!-- Sidebar -->
<div id="sidebar" class="sidebar">

    <button id="closeSidebar" class="btn btn-link text-white d-lg-none float-end">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <a href="{{ url('dashboard') }}">
            <img src="{{ asset('media/Blast Logo.png') }}" alt="logo" class="main-logo">
        </a>
    </div>

    <!-- User Menu Items  -->
    <a href="{{ url('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> <span>My Dashboard</span>
    </a>

    @if($user->status =='complete')
    <a href="{{ url('create-blast') }}" class="{{ request()->is('create-blast') ? 'active' : '' }}">
        <i class="fas fa-bolt"></i> <span>Create A Blast</span>
    </a>
    @endif

    <a href="{{ url('billing-payments') }}" class="{{ request()->is('billing-payments') ? 'active' : '' }}">
        <i class="fas fa-credit-card"></i> <span>Billing Payments</span>
    </a>

    <div class="submenu-wrapper">
        <a href="#" class="submenu-toggle">
            <i class="fa-solid fa-bars-progress"></i> <span>Manage My Blasts</span>
            <i class="fas fa-chevron-down ms-auto"></i>
        </a>
        <ul class="submenu">
            <li><a href="{{ url('contact-type') }}"> <i class="fas fa-angle-right"></i> <span>Contact Type</span></a></li>
            <li><a href="{{ url('my-contacts') }}"> <i class="fas fa-angle-right"></i> <span>My Contacts</span></a></li>
            <li><a href="{{ url('my-networks') }}"> <i class="fas fa-angle-right"></i> <span>My Network</span></a></li>
            <li><a href="{{ url('my-template') }}"> <i class="fas fa-angle-right"></i> <span>My Template</span> </a></li>
        </ul>
    </div>

    <div class="submenu-wrapper">
        <a href="#" class="submenu-toggle">
            <i class="fas fa-users"></i> <span>User Management</span>
            <i class="fas fa-chevron-down ms-auto"></i>
        </a>
        <ul class="submenu">
            <li><a href="{{ url('account') }}"> <i class="fas fa-angle-right"></i> <span>User Account</span></a></li>
            <li><a href="{{ url('subscription') }}"> <i class="fas fa-angle-right"></i> <span>Subscription / Credit</span></a></li>
            <li><a href="{{ url('payment-info') }}"> <i class="fas fa-angle-right"></i> <span>Payment Information</span></a></li>
            <li><a href="{{ url('contact') }}"> <i class="fas fa-angle-right"></i> <span>Contact Us</span></a></li>
        </ul>
    </div>

    <h5 style="color:#fff;" class="my-3">Admin Menus Below</h5>

    <!-- Admin Menu Items -->
    <div class="submenu-wrapper">
        <a href="#" class="submenu-toggle">
            <i class="fas fa-cogs"></i> <span>Subscription Management</span>
            <i class="fas fa-chevron-down ms-auto"></i>
        </a>
        <ul class="submenu">
            <li><a href="{{ url('manage-subscriptions') }}"> <i class="fas fa-angle-right"></i> Subscriptions</a></li>
            <li><a href="{{ url('create-services') }}"> <i class="fas fa-angle-right"></i> Create Service</a></li>
            <li><a href="{{ url('create-subscription') }}"> <i class="fas fa-angle-right"></i> Setup Subscriptions</a></li>
            <li><a href="{{ url('create-discount') }}"> <i class="fas fa-angle-right"></i> Create Discount</a></li>
        </ul>
    </div>

    <a href="{{ url('blast-report') }}" class="{{ request()->is('blast-report') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> <span>Blast Report</span>
    </a>

    <a href="{{ url('blast-payments') }}" class="{{ request()->is('blast-payments') ? 'active' : '' }}">
        <i class="fas fa-credit-card"></i> <span>Blast Payments</span>
    </a>

    <a href="{{ url('support-tickets') }}" class="{{ request()->is('support-tickets') ? 'active' : '' }}">
        <i class="fa-solid fa-headset"></i> <span>Support Tickets</span>
    </a>

    <a href="{{ url('admin-dashboard') }}" class="{{ request()->is('admin-dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> <span>Admin Dashboard</span>
    </a>

    <a href="{{ url('service-payments') }}" class="{{ request()->is('service-payments') ? 'active' : '' }}">
        <i class="fas fa-money-bill-wave"></i> <span>Service Payments</span>
    </a>
</div>

<!-- Mobile overlay -->
<div id="sidebarOverlay" class="sidebar-overlay d-lg-none"></div>