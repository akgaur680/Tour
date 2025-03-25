const columns = [
    { data: "id" },
    { data: "car_image" },
    { data: "car_number" },
    { data: "car_model" },
    { data: "car_type" },
    {
        data: null,

        render: function (data, type, row) {
            return `
                <button onclick="viewCar(${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-eye"></i></button>
                <button onclick="editCar(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-edit"></i></button>
                <button onclick="deleteCar(${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-trash-alt"></i></button>
            `;
        },
    },
];
InitializeTable("carTable", "/admin/cars", columns);

// Delete Car Function
function deleteCar(id) {
    if (confirm("Are you sure you want to delete this Car?")) {
        fetch(`/admin/cars/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                alert(data.message);
                console.log(data);
                dataTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
            })
            .catch((error) => console.error("Error:", error));
    }
}
