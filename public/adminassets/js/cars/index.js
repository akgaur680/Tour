const carColumns = [
    { data: "DT_RowIndex", title:'#' },
    { data: "car_image", title: "Car Image" },
    { data: "car_number", title: "Car Number" },
    { data: "car_model" , title: "Car Manufacturing Year" },
    { data: "car_type" ,title: "Car Name" },
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
    InitializeTable("carTable", "/admin/cars", carColumns);

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

                    dataTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
                    console.log(data);
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

function validateCarForm(formData) {
    const errors = [];

    const name = formData.get("car_number")?.trim() || "";
    const model = formData.get("car_model")?.trim() || "";
    const price = formData.get("price_per_km")?.trim() || "";
    const carImage = formData.get("car_image");
    const type = formData.get('car_type')?.trim() || "";
    const seats = formData.get('seats')?.trim() || "";
    const luggage_limit = formData.get('luggage_limit')?.trim() || "";
    const ac = formData.get('ac')?.trim() || "";

    if (!name) {
        errors.push({ field: "car_number", message: "Car number is required." });
    }

    if (!model) {
        errors.push({ field: "car_model", message: "Car model is required." });
    }
    if (!type) {
        errors.push({ field: "car_type", message: "Car Type is required." });
    }
    if (!seats) {
        errors.push({ field: "seats", message: "No. of Seats is required." });
    }
    if (!luggage_limit) {
        errors.push({ field: "luggage_limit", message: "Luggage Limit is required." });
    }
    if (!ac) {
        errors.push({ field: "ac", message: "AC Availablity is required." });
    }
    if (!price) {
        errors.push({ field: "price_per_km", message: "Price per km is required." });
    } else if (isNaN(price) || parseFloat(price) <= 0) {
        errors.push({ field: "price_per_km", message: "Price must be a valid positive number." });
    }

    if (carImage && carImage.name) { // Validate Image (if uploaded)
        const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
        if (!allowedTypes.includes(carImage.type)) {
            errors.push({ field: "car_image", message: "Only JPG, JPEG, PNG, and WEBP images are allowed." });
        }

        if (carImage.size > 2 * 1024 * 1024) { // 2MB limit
            errors.push({ field: "car_image", message: "Image size must not exceed 2MB." });
        }
    }

    return errors;
}





