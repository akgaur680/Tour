
function submitVerification(status) {
    const orderId = document.getElementById('payment_order_id').value;
    const verifyAction = document.getElementById('verify_action').value;

    if (!verifyAction) {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Please select verification status."
        });
        return;
    }

    fetch(`/admin/verify-payment/${orderId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            verify_action: verifyAction,
        }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.status == true) {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: data.message,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
            });
            closeDiv(event, 'verifyPaymentDiv');
            dataTable.ajax.reload(); // or refresh your data table
        } else {
           Swal.fire({
               icon: "error",
               title: "Error!",
               text: data.message
           })
        }
    })
    .catch((error) => {
        console.error("Update error:", error);
    });
}


function verifyPayment(event, id) {
    event.preventDefault();
    showForm(event, 'verifyPaymentDiv', 'verify-payments', 'edit');

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

            document.getElementById('payment_order_id').value = payment.id;
            document.getElementById('verify_received_amount').textContent = payment.received_amount ?? '0.00';

            const img = document.getElementById('verify_payment_proof_img');
            if (payment.payment_proof) {
                img.src = `/storage/${payment.payment_proof}`;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }

            // Reset the dropdown
            document.getElementById('verify_action').value = '';
        }
    })
    .catch((error) => {
        console.error("Error loading payment info:", error);
    });
}


