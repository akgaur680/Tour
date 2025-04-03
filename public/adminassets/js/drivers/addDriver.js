// Add Car Function
function adddrivers(event) {
    event.preventDefault();
    const form = document.getElementById("driversForm");
    const formData = new FormData(form);

    // Clear previous errors
    clearErrors();

    // Validate Form
    const validationErrors = validateDriverForm(formData);
    if (validationErrors.length > 0) {
        showValidationErrors(validationErrors);
        return;
    }

    fetch("/admin/drivers", {
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
            dataTable.ajax.reload(null, false); // Reload DataTable
            form.reset();
            closeDiv(event, "driversDiv");
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

