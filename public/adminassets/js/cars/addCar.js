// Add Car Function
function addcars(event) {
    event.preventDefault();
    const form = document.getElementById("addCarForm");
    const formData = new FormData(form);
    console.log(formData.get("trip_type_ids[]"));

    fetch("/admin/cars", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": formData.get("_token"),
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status == true) {
                Swal.fire({
                    icon: "success",
                    title: "Added!",
                    text: data.message,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                });
                dataTable.ajax.reload(null, false); // Reload DataTable
                form.reset();
                closeDiv(event, "addCarDiv");
            } else if (data.success == false) {
                let errorMessages = data.errors; // Array of errors

                errorMessages.forEach((error, index) => {
                    setTimeout(() => {
                        toastr.error(error, "Error!", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 3000,
                        });
                    }, index * 1000); // Show each error with a 1-second delay
                });
            }
        })
        .catch((error) => console.error("Error:", error));
}

function toggleDropdown() {
    const menu = document.getElementById("dropdownOptions");
    menu.style.display = menu.style.display === "none" ? "block" : "none";
}

function updateSelectedTripTypes() {
    const checkboxes = document.querySelectorAll(
        '#dropdownOptions input[type="checkbox"]'
    );
    const displayInput = document.getElementById("trip_type_ids_display");
    const hiddenInput = document.getElementById("trip_type_ids_hidden");

    const selectedNames = [];
    const selectedValues = [];

    checkboxes.forEach((cb) => {
        if (cb.checked) {
            selectedNames.push(cb.parentElement.textContent.trim());
            selectedValues.push(cb.value);
        }
    });

    displayInput.value = selectedNames.join(", ");

    // Clear previous hidden inputs
    document
        .querySelectorAll('input[name="trip_type_ids[]"]')
        .forEach((el) => el.remove());

    // Add selected values as hidden inputs
    const container = document.getElementById("tripTypeDropdown");
    selectedValues.forEach((val) => {
        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "trip_type_ids[]";
        hidden.value = val;
        container.appendChild(hidden);
    });
}

// Close dropdown when clicking outside
document.addEventListener("click", function (e) {
    const dropdown = document.getElementById("tripTypeDropdown");
    if (!dropdown.contains(e.target)) {
        document.getElementById("dropdownOptions").style.display = "none";
    }
});
