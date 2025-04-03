function editCar(event, id) {
    fetch(`/admin/cars/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status == true) {
                console.log(data);

                // Open form with edit mode
                showForm(event, "addCarDiv", "cars", "edit", "Edit", "Update");

                // Set form values
                document.getElementById("car_model").value = data.car.car_model;
                document.getElementById("car_number").value = data.car.car_number;
                document.getElementById("car_type").value = data.car.car_type;
                document.getElementById("seats").value = data.car.seats;
                document.getElementById("luggage_limit").value = data.car.luggage_limit;
                document.getElementById("price_per_km").value = data.car.price_per_km;
                document.getElementById("ac").value = data.car.ac.toString();

                // Update car image preview
                const carImage = document.getElementById("carimage");
                carImage.src = data.car.car_image
                    ? `/storage/${data.car.car_image}`
                    : "/adminassets/dist/img/defaultCar.avif";
                carImage.style.display = "block"; // Ensure it is visible

                // Update title and button text
                document.getElementById("div-title").textContent = "Update";
                const btn = document.getElementById("submitBtn");
                btn.textContent = "Update";
                btn.setAttribute("onclick", `updateCar(event, ${data.car.id})`);
            }
        });
}


function updateCar(event, id) {
    event.preventDefault();

    const form = document.getElementById("addCarForm");
    const formData = new FormData(form);
    formData.append("_method", "PUT");

    // Clear previous errors
    clearErrors();

    // Validate Form
    const validationErrors = validateCarForm(formData);
    if (validationErrors.length > 0) {
        showValidationErrors(validationErrors);
        return;
    }

    fetch(`/admin/cars/${id}`, {
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
                dataTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
                form.reset();
                closeDiv(null, "addCarDiv");
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
