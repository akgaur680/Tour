function submitApprovalStatus(event, id) {
    event.preventDefault();
    const approvalStatus = document.getElementById("approval_status").value ? document.getElementById("approval_status").value : 1;
    const driverId = id;

    if (approvalStatus === "") {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Please select an approval status.",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000
        })
        return;
    }

    fetch(`/admin/driver-request/${driverId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ is_approved: approvalStatus }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === true) {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: data.message,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
            });
            if(document.getElementById('viewDriverRequestDiv').style.display === 'block'){
                closeDiv(event, 'viewDriverRequestDiv')
            }
            dataTable.ajax.reload(null, false);
            // Optionally reload or hide the form
        } else {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: data.message,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
            })
        }
    })
    .catch(error => {
        console.error("Approval error:", error);
        alert("An error occurred.");
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "An error occurred. Please try again.",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000
        })
    });
}
