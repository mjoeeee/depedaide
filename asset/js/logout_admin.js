function confirmLogout() {
    Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, log me out!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {  // Only redirect if "Yes" is clicked
            window.location.href = "../logout.php"; 
        }
    });
}
