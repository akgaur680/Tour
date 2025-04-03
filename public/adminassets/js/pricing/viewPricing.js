function viewPricing(event, id) {
    event.preventDefault();
    showForm(event, "viewPricingDiv", "pricing", "view");
    console.log("View Pricing Button Clicked");

    fetch(`/admin/fixed-pricing/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === true) {
                console.log(data);
                tripType = "";
                if (data.pricing.trip_type_id == 1) {
                    tripType = "One-Way";
                } else if (data.pricing.trip_type_id == 4) {
                    tripType = "Airport";
                }
                // Populate the View Car Modal
                document.getElementById("view_trip_type").textContent =
                    tripType;
                document.getElementById("view_origin").textContent = data
                    .pricing.origin_city_id
                    ? data.pricing.origin_city.name +
                      ", " +
                      data.pricing.origin_state.name
                    : data.pricing.airport.name;
                document.getElementById("view_destination").textContent =
                data.pricing.destination_city_id
                ? data.pricing.destination_city.name +
                  ", " +
                  data.pricing.destination_state.name
                : data.pricing.airport.name;
                document.getElementById("view_price").textContent =
                    data.pricing.price;
                document.getElementById("view_car_name").textContent =
                    data.pricing.car.car_type;
                document.getElementById("view_car_number").textContent =
                    data.pricing.car.car_number;
                document.getElementById("view_price_per_km").textContent =
                    data.pricing.car.price_per_km;
                // Update Profile image
                const carImage = document.getElementById("view_car_image");
                carImage.src = data.pricing.car.car_image
                    ? `/storage/${data.pricing.car.car_image}`
                    : "/adminassets/dist/img/defaultProfile.avif";
                carImage.style.display = "block"; // Ensure it is visible
            }
        })
        .catch((error) => console.error("Error:", error));
}
