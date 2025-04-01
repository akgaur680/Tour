function viewCar(event, id) {
    event.preventDefault();
    showForm(event, 'viewCarDiv', 'cars', 'view');

    fetch(`/admin/cars/${id}`, {
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
                document.getElementById("view_car_number").textContent = data.car.car_number;
                document.getElementById("view_car_model").textContent = data.car.car_model;
                document.getElementById("view_car_type").textContent = data.car.car_type;
                document.getElementById("view_seats").textContent = data.car.seats;
                document.getElementById("view_luggage_limit").textContent = data.car.luggage_limit;
                document.getElementById("view_price_per_km").textContent = data.car.price_per_km;
                document.getElementById("view_ac").textContent = data.car.ac == 1 ? "AC" : "Non-AC";

                // Update car image
                const carImage = document.getElementById("view_car_image");
                if (data.car.car_image) {
                    carImage.src = `/storage/${data.car.car_image}`; // Ensure this is a valid image URL
                } else {
                    carImage.src = "/adminassets/dist/img/defaultCar.avif"; // Fallback image
                }

                // Show the View Car modal
                document.getElementById("viewCarDiv").style.display = "block";
            }
        })
        .catch((error) => console.error("Error:", error));
}
