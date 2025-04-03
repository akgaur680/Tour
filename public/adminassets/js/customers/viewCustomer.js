function viewCustomer(event, id) {
    event.preventDefault();
    showForm(event, 'viewCustomerDiv', 'customers', 'view');
    console.log('View Customer Button Clicked');
    

    fetch(`/admin/customers/${id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === true) {
                console.log(data);

                // Populate the View Car Modal
                document.getElementById("view_name").textContent = data.customer.name ? data.customer.name : 'N/A';
                document.getElementById("view_email").textContent = data.customer.email ? data.customer.email : 'N/A';
                document.getElementById("view_mobile_no").textContent = data.customer.mobile_no ? data.customer.mobile_no : 'N/A';
                document.getElementById("view_dob").textContent = data.customer.dob ? data.customer.dob : 'N/A';
                const rawDate = data.customer.created_at;
                const formattedDate = new Date(rawDate).toLocaleDateString("en-GB", {
                    day: "2-digit",
                    month: "2-digit",
                    year: "numeric"
                });

                document.getElementById("view_joined_on").textContent = formattedDate;
           
                document.getElementById("view_joined_on").textContent = data.customer.created_at ? formattedDate : 'N/A';

                addressDiv = document.getElementById("addressDiv");   
                if(data.customer.address){
                    addressDiv.style.display = "block";
                    document.getElementById("view_address").textContent = data.customer.address;
                }
                // Update Profile image
                const profileImage = document.getElementById("view_profile_image");
                profileImage.src = data.customer.profile_image
                    ? `/storage/${data.customer.profile_image}`
                    : "/adminassets/dist/img/defaultCar.avif";
                profileImage.style.display = "block"; // Ensure it is visible
             
            }
        })
        .catch((error) => console.error("Error:", error));
}
