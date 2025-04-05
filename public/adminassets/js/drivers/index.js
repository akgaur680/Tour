const driverColumns = [
    { data: "DT_RowIndex" , title: '#'},
    { data: "user.name", title: 'Name' },
    { data: "driving_license", title: 'Driving License' },
    { data: "user.mobile_no", title: 'Mobile Number' },
    { data: "is_available", title:'Availablity', orderable: false, searchable: false },
    { data: "is_approved", title:'Approval Status', orderable: false, searchable: false },

    { data: "user.email", title: 'Email' },
    {
        data: null,
        title: "Actions",

        render: function (data, type, row) {
            return `
                <button onclick="viewDriver(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-eye"></i></button>
                <button onclick="editDriver(event, ${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-edit"></i></button>
                <button onclick="deleteDriver(${row.id})" style="all: unset; cursor: pointer;"><i class="fa fa-trash-alt"></i></button>
            `;
        },
    },
];

InitializeTable("driverTable", "/admin/drivers", driverColumns);

// Delete Car Function
function deleteDriver(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/drivers/${id}`, {
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
                        timer: 3000,
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
                        timer: 3000,
                    });
                });
        }
    });
}



