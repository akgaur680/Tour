const driverColumns = [
    { data: "id" },
    { data: "user.name" },
    { data: "driving_license" },
    { data: "user.mobile_no" },
    { data: "user.email" },
    {
        data: null,

        render: function (data, type, row) {
            return `
                <button onclick="viewDriver(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-eye"></i></button>
                <button onclick="editDriver(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-edit"></i></button>
                <button onclick="deleteDriver(${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-trash-alt"></i></button>
            `;
        },
    },
];


InitializeTable("driverTable", "/admin/drivers", driverColumns);

// Delete Car Function
function deleteDriver(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/drivers/${id}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: data.message,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });

                    console.log(data);
                    dataTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
        }
    });
}

function validateDriverForm(formData) {
    const errors = [];

    const name = formData.get("name")?.trim() || "";
    const email = formData.get("email")?.trim() || "";
    const mobile = formData.get("mobile_no")?.trim() || "";
    const license = formData.get("driving_license").trim() || "";
    const license_expiry = formData.get('license_expiry')?.trim() || "";
    const address = formData.get('address')?.trim() || "";
    const licenseImage = formData.get('license_image');
    const profileImage = formData.get('profile_image');
    if (!name) {
        errors.push({ field: "name", message: "Name is required." });
    }

    if (!email) {
        errors.push({ field: "email", message: "Email ID is required." });
    }
    if (!mobile) {
        errors.push({ field: "mobile_no", message: "Mobile Number is required." });
    }
    if (!license) {
        errors.push({ field: "driving_license", message: "Driving License Number is required." });
    }
    if (!license_expiry) {
        errors.push({ field: "license_expiry", message: "License Expiry Date is required." });
    }
    if (!address) {
        errors.push({ field: "address", message: "Address is required." });
    }


    if (licenseImage && licenseImage.name) { // Validate Image (if uploaded)
        const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
        if (!allowedTypes.includes(licenseImage.type)) {
            errors.push({ field: "license_image", message: "Only JPG, JPEG, PNG, and WEBP images are allowed." });
        }

        if (licenseImage.size > 2 * 1024 * 1024) { // 2MB limit
            errors.push({ field: "license_image", message: "Image size must not exceed 2MB." });
        }
    }

    if (profileImage && profileImage.name) { // Validate Image (if uploaded)
        const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
        if (!allowedTypes.includes(profileImage.type)) {
            errors.push({ field: "profile_image", message: "Only JPG, JPEG, PNG, and WEBP images are allowed." });
        }

        if (profileImage.size > 2 * 1024 * 1024) { // 2MB limit
            errors.push({ field: "profile_image", message: "Image size must not exceed 2MB." });
        }
    }

    return errors;
}


