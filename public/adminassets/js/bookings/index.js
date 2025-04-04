const bookingColumn = [
    { data: 'DT_RowIndex', title: '#' },
    { data: 'user.name', title: 'Customer Name' },
    { data: 'user.mobile_no', title: 'Customer Mobile No' },
    { data: 'pickup_location', title: 'Pickup Location' },
    { data: 'drop_location', title: 'Drop Location' },
    { data: 'pickup_date', title: 'Pickup Date' },
    { data: 'pickup_time', title: 'Pickup Time' },
    { data: 'payment_status', title: 'Payment Status'},
    { data: 'booking_status', title: 'Booking Status', 
        render: function (data, type, row) {
            let status = '';
            if (row.booking_status == 'upcoming') {
                status = '<span class="badge badge-warning">Up-Coming</span>';
            } else if (row.booking_status == 'ongoing') {
                status = '<span class="badge badge-info">On-Going</span>';
            } else if (row.booking_status == 'completed') {
                status = '<span class="badge badge-success">Completed</span>';
            } else if (row.booking_status == 'cancelled') {
                status = '<span class="badge badge-danger">Cancelled</span>';
            }
            return status;
        }

     },
    { 
        data: 'actions', title: 'Actions', 
        render: function (data, type, row) {
            console.log(row);
            
            if (row.booking_status === 'upcoming') {
                return `
                    <button onclick="cancelBooking(${row.booking_token})" class="badge badge-danger">
                       Cancel Booking
                    </button>
                `;
            }
            return 'Cannot Cancel'; // No button if the status is not 'upcoming'
        },
        orderable: false,
        searchable: false
    }
];

InitializeTable('bookingTable', '/admin/bookings', bookingColumn);



function cancelBooking(token) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, Cancel it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/cancel-booking/${token}`, {
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