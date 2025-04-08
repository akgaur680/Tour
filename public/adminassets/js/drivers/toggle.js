document.addEventListener("DOMContentLoaded", function () {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    // Handle availability toggle
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("toggle-availability")) {
            const driverId = event.target.dataset.id;
            const isAvailable = event.target.checked ? 1 : 0;

            fetch(`/admin/drivers/${driverId}/toggle-availability`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ is_available: isAvailable })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Driver Availability Updated",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });
                    reloadTable('driverTable');

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to Update Availability",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong!",
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        }
    });

    // Handle approval toggle
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("toggle-approval")) {
            const driverId = event.target.dataset.id;
            const isApproved = event.target.checked ? 1 : 0;

            fetch(`/admin/drivers/${driverId}/toggle-approval`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ is_approved: isApproved })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Driver Approval Updated",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });
                    reloadTable('driverTable');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to Update Approval",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong!",
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000
                })
            });
        }
    });
});