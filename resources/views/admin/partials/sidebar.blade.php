<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h2 class="sidebar-title">Make It Blast</h2>
        <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Icon" class="collapsed-logo">
    </div>

    <ul>
        <li>
            <a href="{{ url('dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>My Dashboard</span></a>
        </li>

        <li>
            <a href="{{ url('create-blast') }}"><i class="fas fa-bolt"></i> <span>Create A Blast</span></a>
        </li>

        <li>
            <a href="{{ url('billing-payments') }}"><i class="fas fa-credit-card"></i> <span>Blast Payments</span></a>
        </li>

        <li>
            <a href="{{ url('service-payments') }}"><i class="fas fa-money-bill-wave"></i> <span>Service Payments</span></a>
        </li>

        <li>
            <a href="#" class="submenu-toggle"><i class="fas fa-cogs"></i> <span>Subscription Management</span>
                <i class="fas fa-chevron-down ms-auto"></i></a>
            <ul class="submenu">
                <li><a href="{{ url('manage-subscriptions') }}"><i class="fas fa-angle-right"></i> Subscriptions</a></li>
                <li><a href="{{ url('create-services') }}"><i class="fas fa-angle-right"></i> Create Service</a></li>
                <li><a href="{{ url('create-subscription') }}"><i class="fas fa-angle-right"></i> Setup Subscriptions</a></li>
                <li><a href="{{ url('create-discount') }}"><i class="fas fa-angle-right"></i> Create Discount</a></li>
            </ul>
        </li>

        <li>
            <a href="#" class="submenu-toggle"><i class="fa-solid fa-bars-progress"></i> <span>Manage My Blasts</span>
                <i class="fas fa-chevron-down ms-auto"></i></a>
            <ul class="submenu">
                <li><a href="{{ url('contact-type') }}"><i class="fas fa-angle-right"></i>Contact Type</a></li>
                <li><a href="{{ url('my-contacts') }}"><i class="fas fa-angle-right"></i>My Contacts</a></li>
                <li><a href="{{ url('my-networks') }}"><i class="fas fa-angle-right"></i> My Network</a></li>
                <li><a href="{{ url('my-template') }}"><i class="fas fa-angle-right"></i> My Template</a></li>
            </ul>
        </li>

        <li>
            <a href="{{ url('blast-report') }}"><i class="fas fa-chart-line"></i> <span>Blast Report</span></a>
        </li>

        <li>
            <a href="{{ url('billing-payments') }}"><i class="fas fa-credit-card"></i> <span>Billing And Payments</span></a>
        </li>

        <li>
            <a href="#" class="submenu-toggle"><i class="fas fa-users"></i> <span>User Management</span>
                <i class="fas fa-chevron-down ms-auto"></i></a>
            <ul class="submenu">
                <li><a href="{{ url('account') }}"><i class="fas fa-angle-right"></i> User Account</a></li>
                <li><a href="{{ url('subscription') }}"><i class="fas fa-angle-right"></i> Subscription / Credit</a></li>
                <li><a href="{{ url('payment-info') }}"><i class="fas fa-angle-right"></i> Payment Information</a></li>
                <li><a href="{{ url('contact') }}"><i class="fas fa-angle-right"></i> Contact Us</a></li>
            </ul>
        </li>

        <li>
            <a href="{{ url('admin-dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Admin Dashboard</span></a>
        </li>
    </ul>
</div>