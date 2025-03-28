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
                showForm(event, "addCarDiv", 'edit');
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
                ac.setAttribute("selected", "selected"); // Corrected method name

                  // Update car image
                  const carImage = document.getElementById("car_image");
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
    const car_model = document.getElementById("car_model").value;
    const car_number = document.getElementById("car_number").value;
    const car_type = document.getElementById("car_type").value;
    const seats = document.getElementById("seats").value;
    const luggage_limit = document.getElementById("luggage_limit").value;
    const price_per_km = document.getElementById("price_per_km").value;
    const ac = document.getElementById("ac").value;

    fetch(`/admin/cars/${id}`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ car_model, car_number, car_type, seats, luggage_limit, price_per_km, ac }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status == true) {
                alert(data.message);
                console.log(data);
                dataTable.ajax.reload(null, false); // Reload DataTable
                closeDiv(event, "addCarDiv");
            }
        })
        .catch((error) => console.error("Error:", error));
}
