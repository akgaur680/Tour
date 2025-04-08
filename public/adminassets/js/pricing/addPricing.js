function addPricing(event) {
    event.preventDefault();
    const tripTypeRadios = document.querySelectorAll("input[name='trip_type']");
    const airportTypeRadios = document.querySelectorAll("input[name='airport_type']");
    const originField = document.getElementById("origin");
    const destinationField = document.getElementById("destination");
    const airportIdField = document.getElementById("airport_name");
    const destinationTypeDiv = document.querySelector("[name='airport_type']").closest(".col-sm-6");
    const carTypeId = document.getElementById('car_type').value;
    const form = document.getElementById("pricingForm");
    const formData = new FormData(form);
    
console.log(airportIdField.dataset.airportId);

    formData.append('car_id', carTypeId);

    if (originField.closest(".col-sm-6").style.display !== "none") {
        formData.append("origin", originField.value);
        formData.append('origin_city_id', originField.dataset.cityId);
        formData.append('origin_state_id', originField.dataset.stateId);
    }
    if (destinationField.closest(".col-sm-6").style.display !== "none") {
        formData.append("destination", destinationField.value);
        formData.append('destination_city_id', destinationField.dataset.cityId);
        formData.append('destination_state_id', destinationField.dataset.stateId);
    }
    if (airportIdField.closest(".col-sm-6").style.display !== "none") {
        formData.append("airport", airportIdField.value);
        formData.append('airport_id', airportIdField.dataset.airportId);

    }
    
    formData.append('trip_type_id', document.querySelector("input[name='trip_type']:checked").value);
    fetch("/admin/fixed-pricing", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value
        }
    })
    .then(response => response.json())
    .then((data) => {
        if (data.status == true) {
            Swal.fire({
                icon: "success",
                title: "Added!",
                text: data.message,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
            });
            reloadTable('pricingTable');
            form.reset();
            closeDiv(event, "pricingDiv");
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