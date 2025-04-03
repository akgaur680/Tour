function editDriver(event, id) {
    event.preventDefault();

    fetch(`/admin/drivers/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status == true) {
                console.log(data);
                showForm(event, "driversDiv", "drivers", "edit", "Edit", "Update");
                const name = document.getElementById("name");
                const email = document.getElementById("email");
                const mobile_no = document.getElementById("mobile_no");
                const car_id = document.getElementById("car_id");
                const driving_license = document.getElementById("driving_license");
                const adhaar_number = document.getElementById("adhaar_number");
                const dob = document.getElementById("dob");
                const license_expiry = document.getElementById("license_expiry");
                const address = document.getElementById("address");
               
                name.value = data.driver.user.name;
                email.value = data.driver.user.email;
                mobile_no.value = data.driver.user.mobile_no;
                driving_license.value = data.driver.driving_license;
                adhaar_number.value = data.driver.adhaar_number;
                dob.value = data.driver.user.dob;
                license_expiry.value = data.driver.license_expiry;
                address.value = data.driver.user.address;
                // Set the car_id value
                car_id.value = data.driver.car_id; // Set the value
                car_id.value = data.driver.car_id.toString(); 

                 // Update Profile image
                 const profileImage = document.getElementById("profile_image_preview");
                 profileImage.src = data.driver.user.profile_image
                     ? `/storage/${data.driver.user.profile_image}`
                     : "/adminassets/dist/img/defaultProfile.avif";
                 profileImage.style.display = "block"; // Ensure it is visible
                // Update License image
                const licenseImage = document.getElementById("license_image_preview");
                licenseImage.src = data.driver.license_image
                    ? `/storage/${data.driver.license_image}`
                    : "/adminassets/dist/img/defaultLicense.avif";
                licenseImage.style.display = "block"; // Ensure it is visible

                // Update Adhaar image
                const adhaarFrontImage = document.getElementById("adhaar_image_front_preview");
                adhaarFrontImage.src = data.driver.adhaar_image_front
                    ? `/storage/${data.driver.adhaar_image_front}`
                    : "/adminassets/dist/img/defaultAdhaar.avif";
                adhaarFrontImage.style.display = "block"; // Ensure it is visible

                const adhaarBackImage = document.getElementById("adhaar_image_back_preview");
                adhaarBackImage.src = data.driver.adhaar_image_back
                    ? `/storage/${data.driver.adhaar_image_back}`
                    : "/adminassets/dist/img/defaultAdhaar.avif";
                adhaarBackImage.style.display = "block"; // Ensure it is visible

                const title = document.getElementById("div-title");
                title.innerHTML = "Update";

                const btn = document.getElementById("submitBtn");
                btn.textContent = "Update";
                btn.setAttribute("onclick", `updateDriver(event, ${data.driver.id});`);
            }
        });
}


function updateDriver(event, id) {
    event.preventDefault();

    const form = document.getElementById("driversForm");
    const formData = new FormData(form);
    formData.append("_method", "PUT");

    // Clear previous errors
    clearErrors();

    // Validate Form
    const validationErrors = validateDriverForm(formData);
    if (validationErrors.length > 0) {
        showValidationErrors(validationErrors);
        return;
    }

    fetch(`/admin/drivers/${id}`, {
        method: "POST", // ✅ Use POST (not PUT)
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status == true) {
                Swal.fire({
                    icon: "success",
                    title: "Updated!",
                    text: data.message,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000
                });
                dataTable.ajax.reload(null, false); // Reload DataTable

                console.log(dataTable.data);
                setTimeout(() => {
                    closeDiv(event, "driversDiv");
                    
                  
                }, 500);
    
                form.reset();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: data.error,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
        .catch((error) => console.error("Error:", error));
}