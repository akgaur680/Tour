function viewDriver(event, id) {
    event.preventDefault();
    showForm(event, 'viewDriverDiv', 'drivers', 'view');
    console.log('View Driver Button Clicked');
    

    fetch(`/admin/drivers/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === true) {
                console.log(data);

                // Populate the View Car Modal
                document.getElementById("view_name").textContent = data.driver.user.name;
                document.getElementById("view_email").textContent = data.driver.user.email;
                document.getElementById("view_mobile_no").textContent = data.driver.user.mobile_no;
                document.getElementById("view_car").textContent = data.driver.car.car_type;
                document.getElementById("view_driving_license").textContent = data.driver.driving_license;
                document.getElementById("view_adhaar_number").textContent = data.driver.adhaar_number;
                document.getElementById("view_dob").textContent = data.driver.user.dob;
                document.getElementById("view_license_expiry").textContent = data.driver.license_expiry;
                document.getElementById("view_address").textContent = data.driver.user.address;
                // Update Profile image
                const profileImage = document.getElementById("view_profile_image");
                profileImage.src = data.driver.user.profile_image
                    ? `/storage/${data.driver.user.profile_image}`
                    : "/adminassets/dist/img/defaultProfile.avif";
                profileImage.style.display = "block"; // Ensure it is visible
               // Update License image
               const licenseImage = document.getElementById("view_driving_license_image");
               licenseImage.src = data.driver.license_image
                   ? `/storage/${data.driver.license_image}`
                   : "/adminassets/dist/img/defaultLicense.avif";
               licenseImage.style.display = "block"; // Ensure it is visible

               // Update Adhaar image
               const adhaarFrontImage = document.getElementById("view_adhaar_front_image");
               adhaarFrontImage.src = data.driver.adhaar_image_front
                   ? `/storage/${data.driver.adhaar_image_front}`
                   : "/adminassets/dist/img/defaultAdhaar.avif";
               adhaarFrontImage.style.display = "block"; // Ensure it is visible

               const adhaarBackImage = document.getElementById("view_adhaar_back_image");
               adhaarBackImage.src = data.driver.adhaar_image_back
                   ? `/storage/${data.driver.adhaar_image_back}`
                   : "/adminassets/dist/img/defaultAdhaar.avif";
               adhaarBackImage.style.display = "block"; // Ensure it is visible



            }
        })
        .catch((error) => console.error("Error:", error));
}
