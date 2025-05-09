<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    /* General Styles */
    body {
        background-color: #f5f7fb;
        height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    html {
        scroll-behavior: smooth;
    }

    /* Disable scrolling when mobile menu is open */
    body.no-scroll {
        overflow: hidden;
    }

    /* loader */
    #global-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    /* Your Custom Loader Animation */
    .loader {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .jimu-primary-loading:before,
    .jimu-primary-loading:after {
        position: absolute;
        top: 0;
        content: '';
    }

    .jimu-primary-loading:before {
        left: -19.992px;
    }

    .jimu-primary-loading:after {
        left: 19.992px;
        -webkit-animation-delay: 0.32s !important;
        animation-delay: 0.32s !important;
    }

    .jimu-primary-loading:before,
    .jimu-primary-loading:after,
    .jimu-primary-loading {
        background: #076fe5;
        -webkit-animation: loading-keys-app-loading 0.8s infinite ease-in-out;
        animation: loading-keys-app-loading 0.8s infinite ease-in-out;
        width: 13.6px;
        height: 32px;
    }

    .jimu-primary-loading {
        text-indent: -9999em;
        margin: auto;
        position: absolute;
        right: calc(50% - 6.8px);
        top: calc(50% - 16px);
        -webkit-animation-delay: 0.16s !important;
        animation-delay: 0.16s !important;
    }

    @-webkit-keyframes loading-keys-app-loading {

        0%,
        80%,
        100% {
            opacity: .75;
            box-shadow: 0 0 #076fe5;
            height: 32px;
        }

        40% {
            opacity: 1;
            box-shadow: 0 -8px #076fe5;
            height: 40px;
        }
    }

    @keyframes loading-keys-app-loading {

        0%,
        80%,
        100% {
            opacity: .75;
            box-shadow: 0 0 #076fe5;
            height: 32px;
        }

        40% {
            opacity: 1;
            box-shadow: 0 -8px #076fe5;
            height: 40px;
        }
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 250px;
        background: #333;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow-y: auto;
        height: 100vh;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    /* Mobile sidebar styles */
    .sidebar.mobile-active {
        transform: translateX(0);
        z-index: 1001;
    }

    @media (max-width: 992px) {
        .sidebar {
            transform: translateX(-100%);
            width: 280px;
            transition: transform 0.3s ease;
        }

        .sidebar.mobile-active {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 15px 20px;
        }
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 15px;
        position: relative;
    }

    .main-logo {
        width: 100%;
    }

    /* Top-Level Anchor Links */
    .sidebar>a {
        display: flex;
        align-items: center;
        color: #fff;
        padding: 15px 20px;
        text-decoration: none;
        transition: 0.3s;
        font-size: 15px;
        border-left: 4px solid transparent;
    }

    .sidebar a:hover {
        color: #007bff;
    }

    .sidebar a i {
        margin-right: 15px;
    }

    /* Active menu item */
    .sidebar a.active {
        background-color: #cfeaff;
        color: #000 !important;
        position: relative;
    }

    .sidebar a.active:before {
        position: absolute;
        content: "";
        width: 5px;
        height: 100%;
        top: 0px;
        left: -5px;
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        background: #007bff;
        transition: 0.5s;
    }

    .sidebar a.active i {
        color: #000 !important;
    }

    .sub-menu a.active i {
        color: #fff !important;
    }

    /* Submenu wrapper */
    .submenu-wrapper {
        display: block;
    }

    /* Submenu toggle link */
    .submenu-toggle {
        display: flex;
        align-items: center;
        color: #fff;
        padding: 15px 20px;
        text-decoration: none;
        font-size: 15px;
        border-left: 4px solid transparent;
        cursor: pointer;
        transition: 0.3s;
    }

    .submenu-toggle:hover {
        background: #f0f0f0;
    }

    .submenu-toggle i {
        margin-right: 15px;
    }

    /* Submenu styles */
    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-in-out;
        padding-left: 0;
        margin: 0;
    }

    .submenu.show {
        max-height: 500px;
        display: block !important;
    }

    /* Submenu list items */
    .submenu li {
        list-style: none;
    }

    /* Submenu anchor links */
    .submenu li a {
        display: block;
        padding: 10px 20px 10px 40px;
        font-size: 14px;
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
    }

    .submenu.show span {
        margin-left: 5px;
    }

    /* Collapsed styles */
    .sidebar.collapsed .submenu {
        display: none !important;
    }

    .sidebar.collapsed>a,
    .sidebar.collapsed .submenu-toggle {
        justify-content: center;
    }

    .sidebar.collapsed>a span,
    .sidebar.collapsed .submenu-toggle span {
        display: none;
    }

    .sidebar-collapsed .content {
        margin-left: 80px;
        width: 100%;
    }

    /* Hide scrollbar */
    .sidebar::-webkit-scrollbar {
        display: none;
    }

    /* Hide chevron when collapsed */
    .sidebar.collapsed .submenu-toggle i:last-child {
        display: none;
    }

    .submenu-toggle.open {
        background-color: #cfeaff;
        color: #000;
        position: relative;
    }

    .sidebar-header a{
        background-color: rgba(0,0,0,0);
    }

    #closeSidebar i{
        font-size:25px;
    }

    #closeSidebar:hover i::before{
        color:#d32f2f;
    }

    .fa-chevron-down {
        transition: transform 0.3s ease;
    }

    .rotate-180 {
        transform: rotate(180deg);
    }

    .submenu-toggle.open:before {
        position: absolute;
        content: "";
        width: 5px;
        height: 100%;
        top: 0px;
        left: -5px;
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        background: #007bff;
        transition: 0.5s;
    }

    .submenu a.active {
        background-color: #cfeaff;
        color: #000 !important;
        margin: 5px;
        border-radius: 5px;
    }

    .submenu a.active::before {
        display: none;
    }

    .sidebar-header a{
        background-color: rgba(0,0,0,0) !important;
    }

    .sidebar-header a.active::before{
        display: none;
    }

    /* Mobile overlay */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* Content area */
    .content {
        flex-grow: 1;
        transition: margin-left 0.3s ease;
        margin-left: 250px;
        background: linear-gradient(180deg, rgba(72, 127, 255, 1) 30%, rgba(255, 255, 255, 1) 30%);
        min-height: 100vh;
    }

    @media (max-width: 992px) {
        .content {
            margin-left: 0;
            width: 100%;
        }
    }

    .navbar {
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 15px 0px;
    }

    .toggle-btn {
        cursor: pointer;
    }

    /* Data Tables Styling */

    .table-light tr th {
        width: auto !important;
        padding: 20px !important;
        font-size: 14px !important;
        font-weight: 400 !important;
    }



    tbody {
        text-align: center !important;
    }

    tr {
        vertical-align: middle !important;
    }

    td {
        width: auto !important;
        padding: 16px !important;
        word-break: break-word;
        white-space: normal;
        max-width: 240px !important;
        font-size: 14px !important;
        text-transform: capitalize;
    }

    th {
        text-align: center !important;
        background-color: #e0f0ff !important;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        max-width: 100vw;
        padding-bottom: 20px !important;
    }

    .dataTables_length {
        width: fit-content;
        margin-top: 30px;
        float: left;
    }


    .dataTables_filter {
        width: fit-content;
        float: right;
        margin-top: 30px;
        padding-bottom: 20px !important;
    }


    /* Action buttons */
    .action-btns {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .action-btns button {
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
    }


    .action-btns a {
        padding: 6px 12px;
        border: none;
        font-size: 16px;
    }


    .view-btn {
        background-color: #e0f0ff;
        color: #007bff;
    }

    .view-btn:hover {
        background-color: #007bff;
        color: #e0f0ff;
    }


    .edit-btn {
        background-color: #dcfce7;
        color: #198754;
    }

    .edit-btn:hover {
        background-color: #198754;
        color: #dcfce7;
    }


    .delete-btn {
        background-color: #fde2e1;
        color: #dc3545;
    }

    .delete-btn:hover {
        background-color: #dc3545;
        color: #fde2e1;
    }

    .dataTables_filter input {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-left: 5px;
    }

    .dataTables_length select {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    /* Pagination */
    .dataTables_paginate .paginate_button {
        padding: 6px 12px;
        text-decoration: none;
        background: white !important;
        color: #6B7280 !important;
        border: 1px solid #D1D5DB !important;
        border-left: none !important;
        cursor: pointer;
    }


    .dataTables_paginate .paginate_button:hover {
        color: #000 !important;
    }

    .paginate_button.previous {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
        border: 1px solid #D1D5DB !important;
    }

    .paginate_button.next {
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
        border: 1px solid #D1D5DB !important;
    }


    /* Overlay styling */
    #success-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: grid;
        place-items: center;
    }

    /* Success message box */
    #successBox {
        position: relative;
        background: linear-gradient(to right, #e0f7fa, #e3f2fd);
        color: #333;
        border: 1px solid #b2ebf2;
        border-radius: 15px;
        padding: 35px;
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
        font-family: 'Poppins', sans-serif;
        animation: fadeIn 0.5s;
        width: 500px;
        max-width: 90%;
        text-align: center;
    }

    /* Icon styling */
    .icon-container {
        width: 60px;
        height: 60px;
        font-size: 30px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }

    /* Message content */
    .message-content strong {
        font-size: 22px;
        color: #333;
        display: block;
        margin-bottom: 10px;
    }

    .message-content p {
        margin: 0;
        color: #555;
        font-size: 16px;
    }

    /* Close button styling */
    .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        color: #555;
        font-size: 20px;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #f44336;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }


    /* Removing inc dec counter from input type number */

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }


    /* Error message design */

    /* Full-page overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.6);
        /* Semi-transparent black */
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Full-page overlay */
    #errorOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Error container */
    #errorBox {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 500px;
    }

    /* Error box styling */
    .error-box {
        background: #ffebee;
        color: #d32f2f;
        padding: 25px;
        border: 1px solid #f44336;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        width: 500px;
        max-width: 90%;
        position: relative;
        animation: jumpIn 0.5s;
    }

    /* Close button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        color: #555;
        cursor: pointer;
        background: none;
        border: none;
    }

    .close-btn:hover {
        color: #f44336;
    }

    /* Error list styling */
    ul {
        list-style: none;
        padding: 0;
    }

    ul li {
        margin: 5px 0;
        font-size: 16px;
    }

    /* Animation for smooth appearance */
    @keyframes jumpIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /*  Common white background for each section */

    .tab-bg {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    i {
        font-style: normal;
    }



    /* Media queries */

    @media screen and (max-width:1200px) {
        td {
            font-size: 12px;
            width: 230px;
        }
    }

    @media (max-width: 768px) {
        .dataTable {
            font-size: 11px !important;
            min-width: 700px;
            /* Force table to scroll horizontally */
        }

        .dataTables_wrapper {
            overflow-x: auto;
        }

        .table-light tr th,
        td {
            padding: 6px 10px !important;
            white-space: nowrap;
            word-break: break-word;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>