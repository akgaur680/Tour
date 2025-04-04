// Add Car Function
function addcars(event) {
    event.preventDefault();
    const form = document.getElementById("addCarForm");
    const formData = new FormData(form);

    // // Clear previous errors
    // clearErrors();

    // // Validate Form
    // const validationErrors = validateCarForm(formData);
    // if (validationErrors.length > 0) {
    //     showValidationErrors(validationErrors);
    //     return;
    // }

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
            dataTable.ajax.reload(null, false); // Reload DataTable
            form.reset();
            closeDiv(event, "addCarDiv");
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

