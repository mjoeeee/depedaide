
    document.addEventListener("DOMContentLoaded", function () {
        // Restore sidebar state on page load
        if (localStorage.getItem("sidebarActive") === "true") {
            document.getElementById('sidebar').classList.add('active');
        }

        // Restore all dropdowns to be always open across tabs
        document.querySelectorAll(".dropdown").forEach(dropdown => {
            dropdown.classList.add('active'); // Always keep dropdown open
            localStorage.setItem(`dropdown-${dropdown.id}`, "true"); // Store in localStorage
        });
    });

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        localStorage.setItem("sidebarActive", sidebar.classList.contains('active'));
    }

    function toggleDropdown(dropdown) {
        dropdown.classList.toggle('active');
        localStorage.setItem(`dropdown-${dropdown.id}`, "true"); // Ensure it's stored as always open
    }

