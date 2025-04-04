function editPricing(event, id) {
    // event.preventDefault();

    fetch(`/admin/fixed-pricing/${id}`, {
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
                showForm(
                    event,
                    "pricingDiv",
                    "pricing",
                    "edit",
                    "Edit",
                    "Update"
                );
                const origin = document.getElementById("origin");
                const destination = document.getElementById("destination");
                const airport = document.getElementById("airport_name");
                const car = document.getElementById("car_type");
                const price = document.getElementById("price");

                const airportType = document.getElementById("airport_type");
                origin.value = data.pricing.origin_city_id
                    ? data.pricing.origin_city.name +
                      ", " +
                      data.pricing.origin_state.name
                    : "";
                    origin.dataset.cityId = data.pricing.origin_city_id;
                    origin.dataset.stateId = data.pricing.origin_state_id;
                destination.value = data.pricing.destination_city_id
                    ? data.pricing.destination_city.name +
                      ", " +
                      data.pricing.destination_state.name
                    : "";
                    destination.dataset.cityId = data.pricing.destination_city_id;
                    destination.dataset.stateId = data.pricing.destination_state_id;
                airport.value = data.pricing.airport_id
                    ? data.pricing.airport.name
                    : "";
                    airport.dataset.airportId = data.pricing.airport_id;
                    
                car.value = data.pricing.car_id;
                price.value = data.pricing.price;
                const tripTypes = document.querySelectorAll(
                    "input[name='trip_type']"
                );
                const selectedTripType = data.pricing.trip_type_id;

                tripTypes.forEach((radio) => {
                    if (radio.value == selectedTripType) {
                        radio.checked = true;
                    }
                });
                const originField = document.getElementById("origin");
                const destinationField = document.getElementById("destination");
                const airportIdField = document.getElementById("airport_name");
                const destinationTypeDiv = document
                    .querySelector("[name='airport_type']")
                    .closest(".col-sm-6");
                function updateFormDisplay() {
                    const selectedTripType = document.querySelector(
                        "input[name='trip_type']:checked"
                    ).value;

                    if (selectedTripType === "1") {
                        originField.closest(".col-sm-6").style.display =
                            "block";
                        destinationField.closest(".col-sm-6").style.display =
                            "block";
                        airportIdField.closest(".col-sm-6").style.display =
                            "none";
                        destinationTypeDiv.style.display = "none";
                    } else if (selectedTripType === "4") {
                        destinationTypeDiv.style.display = "block";
                        updateAirportTypeDisplay();
                    }
                }
                function updateAirportTypeDisplay() {
                    const selectedAirportType = document.querySelector(
                        "input[name='airport_type']:checked"
                    ).value;
                    const fromAirportInput =
                        document.getElementById("from_airport");
                    const toAirportInput =
                        document.getElementById("to_airport");

                    if (data.pricing.origin_city_id === null) {
                        fromAirportInput.checked = true;
                        airportIdField.closest(".col-sm-6").style.display =
                            "block";
                        destinationField.closest(".col-sm-6").style.display =
                            "block";
                        originField.closest(".col-sm-6").style.display = "none";
                    } else if (data.pricing.destination_city_id === null) {
                        toAirportInput.checked = true;
                        airportIdField.closest(".col-sm-6").style.display =
                            "block";
                        originField.closest(".col-sm-6").style.display =
                            "block";
                        destinationField.closest(".col-sm-6").style.display =
                            "none";
                    }
                }

                updateFormDisplay();
                const btn = document.getElementById("submitBtn");
                btn.textContent = "Update";
                btn.setAttribute("onclick", `updatePricing(event, ${data.pricing.id});`);
            }
        });
}

function updatePricing(event, id) {
    event.preventDefault();

    const tripTypeRadios = document.querySelectorAll("input[name='trip_type']");
    const airportTypeRadios = document.querySelectorAll(
        "input[name='airport_type']"
    );
    const originField = document.getElementById("origin");
    const destinationField = document.getElementById("destination");
    const airportIdField = document.getElementById("airport_name");
    const destinationTypeDiv = document
        .querySelector("[name='airport_type']")
        .closest(".col-sm-6");
    const carTypeId = document.getElementById("car_type").value;
    const form = document.getElementById("pricingForm");
    const formData = new FormData(form);

    console.log(airportIdField.dataset.airportId);

    formData.append("car_id", carTypeId);

    if (originField.closest(".col-sm-6").style.display !== "none") {
        formData.append("origin", originField.value);
        formData.append("origin_city_id", originField.dataset.cityId);
        formData.append("origin_state_id", originField.dataset.stateId);
    }
    if (destinationField.closest(".col-sm-6").style.display !== "none") {
        formData.append("destination", destinationField.value);
        formData.append("destination_city_id", destinationField.dataset.cityId);
        formData.append(
            "destination_state_id",
            destinationField.dataset.stateId
        );
    }
    if (airportIdField.closest(".col-sm-6").style.display !== "none") {
        formData.append("airport", airportIdField.value);
        formData.append("airport_id", airportIdField.dataset.airportId);
    }

    formData.append(
        "trip_type_id",
        document.querySelector("input[name='trip_type']:checked").value
    );

    formData.append("_method", "PUT");
    

    // Clear previous errors
    // clearErrors();

    // // Validate Form
    // const validationErrors = validateDriverForm(formData);
    // if (validationErrors.length > 0) {
    //     showValidationErrors(validationErrors);
    //     return;
    // }

    fetch(`/admin/fixed-pricing/${id}`, {
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
                    timer: 3000,
                });
                dataTable.ajax.reload(null, false); // Reload DataTable

                console.log(dataTable.data);
                setTimeout(() => {
                    closeDiv(event, "pricingDiv");
                }, 500);

                form.reset();
            }else if (data.success == false) {
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
