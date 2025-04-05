function viewPayment(event, id) {
    event.preventDefault();
    showForm(event, 'viewVerifyPaymentDiv', 'verify-payments', 'view');

    fetch(`/admin/verify-payment/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.status === true) {
            const payment = data.verify_payment;

            document.getElementById("view_name").textContent = payment.customer_name;
            document.getElementById("view_email").textContent = payment.customer_email;
            document.getElementById("view_mobile_no").textContent = payment.customer_mobile;
            document.getElementById("view_car").textContent = payment.car_name || 'N/A';
            document.getElementById("view_pickup_location").textContent = payment.pickup_location;
            document.getElementById("view_drop_location").textContent = payment.drop_location;
            document.getElementById("view_pickup_date").textContent = payment.pickup_date;
            document.getElementById("view_pickup_time").textContent = payment.pickup_time;
            document.getElementById("view_booking_status").textContent = payment.booking_status;
            document.getElementById("view_payment_status").textContent = payment.payment_status;
            document.getElementById("view_received_amount").textContent = payment.received_amount ?? '0.00';
            document.getElementById("view_total_amount").textContent = payment.total_amount;
            document.getElementById("view_booking_token").textContent = payment.booking_token;

            const proofImage = document.getElementById("view_payment_proof");
            if (payment.payment_proof) {
                proofImage.src = `/storage/${payment.payment_proof}`;
                proofImage.style.display = "block";
            } else {
                proofImage.style.display = "none";
            }
        }
    })
    .catch((error) => {
        console.error("Error fetching payment details:", error);
    });
}

