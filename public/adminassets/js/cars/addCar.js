
// Add Car Function
function addCar(event) {
    event.preventDefault();
    const form = document.getElementById("addCarForm");
    const formData = new FormData(form);

    fetch("/admin/cars", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": formData.get("_token"),
        },
    })
    .then((response) => response.json())
    .then((data) => {
        Swal.fire({
            icon: "success",
            title: "Added!",
            text: data.message,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000
        })
        form.reset();
        closeDiv(event, "addCarDiv");
        dataTable.ajax.reload(null, false); // Reload DataTable
    })
    .catch((error) => console.error("Error:", error));
}
