function editCar(event, id) {
    // event.preventDefault();

    fetch(`/admin/cars/${id}`, {
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
                showForm(event, "addCarDiv", "edit", "Edit Car", "Update Car");
                const car_model = document.getElementById("car_model");
                const car_number = document.getElementById("car_number");
                const car_type = document.getElementById("car_type");
                const seats = document.getElementById("seats");
                const luggage_limit = document.getElementById("luggage_limit");
                const price_per_km = document.getElementById("price_per_km");
                const ac = document.getElementById("ac");
                car_model.value = data.car.car_model;
                car_number.value = data.car.car_number;
                car_type.value = data.car.car_type;
                seats.value = data.car.seats;
                luggage_limit.value = data.car.luggage_limit;
                price_per_km.value = data.car.price_per_km;
                ac.value = data.car.ac; // Set the value
                ac.value = data.car.ac.toString(); 

                //   Update car image
                const carImage = document.getElementById("carimage");
                if (data.car.car_image) {
                    carImage.src = `/storage/${data.car.car_image}`; // Ensure this is a valid image URL
                } else {
                    carImage.src = "/adminassets/dist/img/defaultCar.avif"; // Fallback image
                }

                const title = document.getElementById("car-title");
                title.textContent = "Update Car";

                const btn = document.getElementById("addCarBtn");
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
                dataTable.ajax.reload(null, false);
                form.reset();
                setTimeout(() => closeDiv(null, "addCarDiv"), 200);
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
