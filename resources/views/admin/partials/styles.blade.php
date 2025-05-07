<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    /* General Styles */
    body {
        background-color: #f5f7fb;
        height: 100vh;
    }

    .wrapper {
        display: flex;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 250px;
        background: #ffffff;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        overflow-y: auto;
        height: 100vh;
        position: fixed;
        z-index: 1000;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 15px;
    }

    .sidebar-title {
        font-size: 25px;
        font-weight: bold;
        color: #333;
    }

    .collapsed-logo {
        display: none;
        width: 40px;
    }

    .sidebar.collapsed .sidebar-title {
        display: none;
    }

    .sidebar.collapsed .collapsed-logo {
        display: block;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        position: relative;
    }

    .sidebar ul li a {
        display: flex;
        align-items: center;
        color: #333;
        padding: 15px 20px;
        text-decoration: none;
        transition: 0.3s;
        font-size: 15px;
        border-left: 4px solid transparent;
    }

    .sidebar ul li a:hover {
        background: #f0f0f0;
    }

    .sidebar ul li a i {
        margin-right: 15px;
    }

    .sidebar ul li.active>a {
        background-color: #007bff;
        color: white !important;
    }

    .sidebar ul li.active>a i {
        color: white !important;
    }

    .sidebar ul li.open>a {
        background-color: #0056b3;
        /* Slightly different for submenu parents */
        color: white !important;
    }



    /* Submenu Styles with Smooth Transition */
    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-in-out;
    }

    .submenu.show {
        max-height: 500px;
        display: block !important;
        /* Adjust height as needed */
    }

    .submenu a {
        padding: 10px 20px;
        font-size: 14px;
    }

    .sidebar.collapsed .submenu {
        display: none !important;
    }

    .sidebar.collapsed ul li a {
        justify-content: center;
    }

    .sidebar.collapsed ul li a span {
        display: none;
    }

    .wrapper.sidebar-collapsed .content {
        margin-left: 80px;
        width: 100%;
    }


    /* Content Section */
    .content {
        flex-grow: 1;
        transition: margin-left 0.3s ease;
        margin-left: 250px;
    }

    .navbar {
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 15px 0px;
    }

    .toggle-btn {
        cursor: pointer;
    }


    .sidebar::-webkit-scrollbar {
        display: none;
    }

    .sidebar.collapsed .submenu-toggle i:last-child {
        display: none;
    }


    /* remove border from preview icons */

    .operation-icons button {
        border: none !important;
    }


    /* Overlay styling */
    #success-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Semi-transparent black */
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
        /* Center align the content */
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

    /* Data Table styling */

    .table-responsive {
        overflow-x: hidden !important;
        /* Hide horizontal scrollbar */
        overflow-y: hidden !important;
        /* Hide vertical scrollbar */
    }

    .table-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin: 30px auto;
    }

    .table-header {
        font-weight: 600;
        color: #333;
        font-size: 20px;
        margin-bottom: 15px;
    }

    table.dataTable {
        border-collapse: separate;

        width: 100%;
    }

    table.dataTable thead th {
        background: #f4f6f9;
        color: #555;
        border: none;
        font-weight: 600;
        padding: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    table.dataTable tbody td {
        background: #ffffff;
        color: #333;
        border: none;
    }

    table.dataTable tbody tr {
        transition: 0.3s;
    }

    table.dataTable tbody tr td {
        padding: 10px 15px;
        /* Adjust the padding as needed */
    }

    table.dataTable tbody tr:hover {
        background-color: #f1f1f1;
    }


    #example_filter {
        margin-bottom: 20px;
    }

    .bottom {
        margin-top: 20px;
    }

    /* Pagination container */
    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 20px;
    }

    .dataTables_paginate a {
        text-decoration: none;
        cursor: pointer;
    }

    /* Pagination button styles */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: #007bff;
        /* Blue background */
        color: #fff !important;
        /* White text */
        border-radius: 50%;
        padding: 10px 15px;
        margin: 1px 5px;
        transition: background 0.3s;
        font-size: 16px;
    }

    /* Hover effect */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #0056b3 !important;
        /* Darker blue on hover */
        color: #fff !important;
    }

    /* Active button */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #28a745 !important;
        /* Green for active */
        color: #fff !important;
        border: none;
    }

    /* Disabled buttons */
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        background: #ccc !important;
        /* Grey background for disabled */
        color: #666 !important;
        cursor: not-allowed;
    }

    /* Smaller screens adjustments */
    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            font-size: 12px;
        }
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
        /* Light red background */
        color: #d32f2f;
        /* Dark red text */
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
</style>