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
                <button onclick="viewCar(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-eye"></i></button>
                <button onclick="editCar(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-edit"></i></button>
                <button onclick="deleteCar(${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-trash-alt"></i></button>
            `;
        },
    },
];
InitializeTable("carTable", "/admin/cars", columns);

// Delete Car Function
function deleteCar(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: data.message,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });

                    console.log(data);
                    dataTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
        }
    });
}

