<script>
    //for sidebar effects
    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const logo = document.querySelector('.collapsed-logo');
        const heading = document.querySelector('.sidebar-title');
        const content = document.querySelector('.content');
        const wrapper = document.querySelector('.wrapper');


        // Sidebar toggle functionality with content expansion
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');

            // Add or remove sidebar-collapsed class on the wrapper
            wrapper.classList.toggle('sidebar-collapsed', sidebar.classList.contains('collapsed'));

            // Show/hide logo and heading
            logo.style.display = sidebar.classList.contains('collapsed') ? 'block' : 'none';
            heading.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'block';
        });

        // Submenu toggle with parent menu activation and closing other submenus
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                const submenu = this.nextElementSibling;
                const parentLi = this.parentElement;

                // Toggle submenu visibility
                submenu.classList.toggle('show');
                parentLi.classList.toggle('open');

                // Close other submenus when opening a new one
                document.querySelectorAll('.submenu').forEach(sub => {
                    if (sub !== submenu && sub.classList.contains('show')) {
                        sub.classList.remove('show');
                        sub.parentElement.classList.remove('open');
                    }
                });
            });
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