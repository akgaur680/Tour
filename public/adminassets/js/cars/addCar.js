
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
        alert(data.message);
        console.log(data);
        dataTable.ajax.reload(null, false); // Reload DataTable
    })
    .catch((error) => console.error("Error:", error));
}
