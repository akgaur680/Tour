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

            // Set basic form values
            document.getElementById("car_model").value = data.car.car_model;
            document.getElementById("car_number").value = data.car.car_number;
            document.getElementById("car_type").value = data.car.car_type;
            document.getElementById("seats").value = data.car.seats;
            document.getElementById("luggage_limit").value = data.car.luggage_limit;
            document.getElementById("price_per_km").value = data.car.price_per_km;
            document.getElementById("ac").value = data.car.ac.toString();

            // Set car image
            const carImage = document.getElementById("carimage");
            carImage.src = data.car.car_image
                ? `/storage/${data.car.car_image}`
                : "/adminassets/dist/img/defaultCar.avif";
            carImage.style.display = "block";

            // ✅ Handle Trip Type Selections
            const selectedTripTypeIds = data.car.car_trip_types.map(item => item.trip_type_id);
            const selectedTripTypeNames = data.car.car_trip_types.map(item => item.trip_type.name);

            const checkboxes = document.querySelectorAll('#dropdownOptions input[type="checkbox"]');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectedTripTypeIds.includes(parseInt(checkbox.value));
            });

            // Update visible selected names
            document.getElementById("trip_type_ids_display").value = selectedTripTypeNames.join(", ");

            // Remove previous hidden inputs
            document.querySelectorAll('input[name="trip_type_ids[]"]').forEach(el => el.remove());

            // Append updated hidden inputs
            const container = document.getElementById("tripTypeDropdown");
            selectedTripTypeIds.forEach((val) => {
                const hidden = document.createElement("input");
                hidden.type = "hidden";
                hidden.name = "trip_type_ids[]";
                hidden.value = val;
                container.appendChild(hidden);
            });

            // Update form button
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
                closeDiv(null, "addCarDiv");
                dataTable.ajax.reload(null, true); // Reload DataTable without resetting pagination
                form.reset();
            } else if (data.success == false) {
                let errorMessages = data.errors; // Array of errors
            
                errorMessages.forEach((error, index) => {
                    setTimeout(() => {
                        toastr.error(error, "Error!", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 3000
                        });
                    }, index * 1000); // Show each error with a 1-second delay
                });
            }
        })
        .catch((error) => console.error("Error:", error));
}
