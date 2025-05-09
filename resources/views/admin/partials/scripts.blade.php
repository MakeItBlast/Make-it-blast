<script>
    // CSRF Protection
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // Toastify
    function showToast(message, type = 'success') {
        const toast = document.getElementById('ajaxToast');
        const toastBody = toast.querySelector('.toast-body');

        toastBody.textContent = message;

        if (type === 'success') {
            toast.classList.remove('text-bg-danger');
            toast.classList.add('text-bg-success');
        } else if (type === 'error') {
            toast.classList.remove('text-bg-success');
            toast.classList.add('text-bg-danger');
        }

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }

    // Sidebar Functionality
    document.addEventListener("DOMContentLoaded", function() {
        // Loader functionality
        const loader = document.getElementById('global-loader');
        if (loader) {
            window.addEventListener('beforeunload', () => {
                loader.style.display = 'block';
            });
        }

        // Sidebar elements
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainLogo = document.querySelector('.main-logo');
        const sidebarTitle = document.querySelector('.sidebar-title');

        // Check if mobile view
        function isMobile() {
            return window.innerWidth <= 992;
        }

        // Toggle sidebar
        function toggleSidebar() {
            if (isMobile()) {
                // Mobile behavior
                sidebar.classList.toggle('mobile-active');
                sidebarOverlay.classList.toggle('show');
                document.body.classList.toggle('no-scroll');
            } else {
                // Desktop behavior - modified to keep logo visible
                sidebar.classList.toggle('collapsed');
                document.body.classList.toggle('sidebar-collapsed');
                
                // Only hide the title when collapsed
                if (sidebarTitle) {
                    sidebarTitle.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'block';
                }
                
                // Keep logo always visible on desktop
                if (mainLogo) {
                    mainLogo.style.display = 'block';
                }
            }
        }

        // Close mobile sidebar
        function closeMobileSidebar() {
            sidebar.classList.remove('mobile-active');
            sidebarOverlay.classList.remove('show');
            document.body.classList.remove('no-scroll');
        }

        // Event listeners
        if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeMobileSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeMobileSidebar);

        // Handle window resize
        function handleResize() {
            if (isMobile()) {
                // Reset desktop styles when resizing to mobile
                sidebar.classList.remove('collapsed');
                document.body.classList.remove('sidebar-collapsed');
                if (sidebarTitle) sidebarTitle.style.display = 'block';
            } else {
                // Reset mobile styles when resizing to desktop
                sidebar.classList.remove('mobile-active');
                sidebarOverlay.classList.remove('show');
                document.body.classList.remove('no-scroll');
                // Ensure logo is visible when switching to desktop
                if (mainLogo) mainLogo.style.display = 'block';
            }
        }

        window.addEventListener('resize', handleResize);

        // Initialize sidebar state
        handleResize();

        // Submenu functionality
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const submenuWrapper = this.closest('.submenu-wrapper');
                const submenu = submenuWrapper.querySelector('.submenu');
                const chevron = this.querySelector('.fa-chevron-down');
                
                // Toggle the submenu
                submenu.classList.toggle('show');
                
                // Rotate chevron icon
                if (chevron) {
                    chevron.classList.toggle('rotate-180');
                }
                
                // Close other submenus if on mobile
                if (isMobile()) {
                    document.querySelectorAll('.submenu-wrapper').forEach(wrapper => {
                        if (wrapper !== submenuWrapper) {
                            wrapper.querySelector('.submenu').classList.remove('show');
                            const otherChevron = wrapper.querySelector('.fa-chevron-down');
                            if (otherChevron) otherChevron.classList.remove('rotate-180');
                        }
                    });
                }
            });
        });

        // Close submenus when clicking on links (for mobile)
        document.querySelectorAll('.submenu a').forEach(link => {
            link.addEventListener('click', function() {
                if (isMobile()) {
                    closeMobileSidebar();
                }
            });
        });

        // Active link handling
        document.querySelectorAll('.sidebar a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
                
                // If it's in a submenu, open its parent
                const submenuItem = link.closest('.submenu');
                if (submenuItem) {
                    submenuItem.classList.add('show');
                    const toggle = submenuItem.closest('.submenu-wrapper').querySelector('.submenu-toggle');
                    if (toggle) {
                        const chevron = toggle.querySelector('.fa-chevron-down');
                        if (chevron) chevron.classList.add('rotate-180');
                    }
                }
            }
        });
    });
</script>