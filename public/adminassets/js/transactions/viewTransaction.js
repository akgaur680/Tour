function viewTransaction(event, id) {
    event.preventDefault();
    showForm(event, 'viewTransactionDiv', 'transactions', 'view');

    fetch(`/admin/transactions/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.status === true) {
            const transaction = data.transaction;
            const user = transaction.user || {};
            const driver = transaction.driver || {};
            const car = transaction.car || {};
            const paymentProof = transaction.payment_proof;

            document.getElementById("view_name").textContent = user.name ?? "N/A";
            document.getElementById("view_email").textContent = user.email ?? "N/A";
            document.getElementById("view_mobile_no").textContent = user.mobile_no ?? "N/A";
            document.getElementById("view_car").textContent = car.car_type ?? "N/A";

            document.getElementById("view_pickup_location").textContent = transaction.pickup_location ?? "N/A";
            document.getElementById("view_drop_location").textContent = transaction.drop_location ?? "N/A";
            document.getElementById("view_pickup_date").textContent = transaction.pickup_date ?? "N/A";
            document.getElementById("view_pickup_time").textContent = transaction.pickup_time ?? "N/A";
            if(transaction.booking_status == 'ongoing'){
                document.getElementById("view_booking_status").innerHTML = '<span class="badge badge-info">On-Going</span>';
            }
            else if(transaction.booking_status == 'upcoming'){
                document.getElementById("view_booking_status").innerHTML = '<span class="badge badge-warning">Up-Coming</span>';
            }
            else if(transaction.booking_status == 'completed'){
                document.getElementById("view_booking_status").innerHTML = '<span class="badge badge-success">Completed</span>';
            }
            else if(transaction.booking_status == 'cancelled'){
                document.getElementById("view_booking_status").innerHTML = '<span class="badge badge-danger">Cancelled</span>';
            }
            else if(transaction.booking_status == 'failed'){
                document.getElementById("view_booking_status").innerHTML = '<span class="badge badge-danger">Failed</span>';
            }
            // document.getElementById("view_booking_status").textContent = transaction.booking_status ?? "N/A";
            // document.getElementById("view_payment_status").textContent = transaction.payment_status ?? "N/A";
            if(transaction.payment_status == 'pending'){
                document.getElementById("view_payment_status").innerHTML = '<span class="badge badge-warning">Pending</span>';
            }
            else if(transaction.payment_status == 'partial'){
                document.getElementById("view_payment_status").innerHTML = '<span class="badge badge-info">Failed</span>';
            }
            else if(transaction.payment_status == 'completed'){
                document.getElementById("view_payment_status").innerHTML = '<span class="badge badge-success">Completed</span>';
            }
            document.getElementById("view_booking_token").textContent = transaction.booking_token ?? "N/A";
            document.getElementById("view_received_amount").textContent = transaction.received_amount ?? 0;
            document.getElementById("view_total_amount").textContent = transaction.total_amount ?? 0;

            // Payment proof image
            const paymentProofImage = document.getElementById("view_payment_proof");
            paymentProofImage.src = paymentProof ? `/storage/${paymentProof}` : "/adminassets/dist/img/defaultProfile.avif";
            paymentProofImage.style.display = "block";
        }
    })
    .catch((error) => console.error("Error:", error));
}
