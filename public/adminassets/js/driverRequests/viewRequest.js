function viewDriverRequest(event, id) {
    event.preventDefault();
    showForm(event, 'viewDriverRequestDiv', 'verify-driver-requests', 'view');

    fetch(`/admin/driver-request/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.status === true) {
            const driver = data.driver;

            // Basic Info
            document.getElementById("view_name").textContent = driver.user?.name ?? 'N/A';
            document.getElementById("view_email").textContent = driver.user?.email ?? 'N/A';
            document.getElementById("view_mobile_no").textContent = driver.user?.mobile_no ?? 'N/A';

            // Car Info
            document.getElementById("view_car").textContent = driver.car?.car_model + ' - ' + driver.car?.car_number ?? 'N/A';

            // License & Adhaar
            document.getElementById("view_license").textContent = driver.driving_license ?? 'N/A';
            document.getElementById("view_license_expiry").textContent = driver.license_expiry ?? 'N/A';
            document.getElementById("view_adhaar").textContent = driver.adhaar_number ?? 'N/A';

            // Images
            const licenseImage = document.getElementById("view_license_image");
            licenseImage.src = driver.license_image ? `/storage/${driver.license_image}` : '';
            licenseImage.style.display = driver.license_image ? 'block' : 'none';

            const adhaarFront = document.getElementById("view_adhaar_front");
            adhaarFront.src = driver.adhaar_image_front ? `/storage/${driver.adhaar_image_front}` : '';
            adhaarFront.style.display = driver.adhaar_image_front ? 'block' : 'none';

            const adhaarBack = document.getElementById("view_adhaar_back");
            adhaarBack.src = driver.adhaar_image_back ? `/storage/${driver.adhaar_image_back}` : '';
            adhaarBack.style.display = driver.adhaar_image_back ? 'block' : 'none';

            const profileImg = document.getElementById("view_profile_image");
            profileImg.src = data.driver.user.profile_image ? `/storage/${data.driver.user.profile_image}` : '';
            profileImg.style.display = data.driver.user.profile_image ? 'block' : 'none';

            submitBtn = document.getElementById("updateStatusBtn");
            submitBtn.setAttribute("onclick", `submitApprovalStatus(event, ${data.driver.id})`);
        }
    })
    .catch((error) => {
        console.error("Error fetching driver details:", error);
    });
}
