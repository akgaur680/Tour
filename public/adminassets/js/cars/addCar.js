// Add Car Function
function addCar(event) {
    event.preventDefault();
    const form = document.getElementById("addCarForm");
    const formData = new FormData(form);

    // Clear previous errors
    clearErrors();

    // Validate Form
    const validationErrors = validateCarForm(formData);
    if (validationErrors.length > 0) {
        showValidationErrors(validationErrors);
        return;
    }

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
                timer: 3000
            });
            form.reset();
            closeDiv(event, "addCarDiv");
            dataTable.ajax.reload(null, false); // Reload DataTable
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

