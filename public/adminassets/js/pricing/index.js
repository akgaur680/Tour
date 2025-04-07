const pricingColumns = [
    { data: "DT_RowIndex" , title: "ID" },
    { data: "origin" , title: "Origin"},
    { data: "destination", title: "Destination" },
    { data: "car.car_type", title: "Car Type" },
    { data: "car.car_number", title: "Car Number" },
    { data: "price" , title: "Price"},
    {
        data: null,
        title: "Actions",
        render: function (data, type, row) {

            return `
                <button onclick="viewPricing(event,${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-eye"></i>
                </button>
                <button onclick="editPricing(event,${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-edit"></i>
                </button>
                <button onclick="deletePricing(${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-trash-alt"></i>
                </button>
            `;
        },
    },
];


InitializeTable("pricingTable", "/admin/fixed-pricing", pricingColumns);


document.addEventListener("DOMContentLoaded", function () {
    const tripTypeRadios = document.querySelectorAll("input[name='trip_type']");
    const airportTypeRadios = document.querySelectorAll(
        "input[name='airport_type']"
    );
    const originField = document.getElementById("origin");
    const destinationField = document.getElementById("destination");
    const airportIdField = document.getElementById("airport_name");
    const destinationTypeDiv = document
        .querySelector("[name='airport_type']")
        .closest(".col-sm-6");
    const airportTypeDiv = document.getElementById("airportTypeDiv"); 

    const fields = [
        {
            input: "origin",
            dropdown: "originDropdown",
            api: "/admin/get-city-state",
        },
        {
            input: "destination",
            dropdown: "destinationDropdown",
            api: "/admin/get-city-state",
        },
        {
            input: "airport_name",
            dropdown: "airportDropdown",
            api: "/admin/get-airports",
        },
    ];

    fields.forEach(({ input, dropdown, api }) => {
        const inputField = document.getElementById(input);
        const dropdownMenu = document.getElementById(dropdown);

        inputField.addEventListener("focus", function () {
            if (dropdownMenu.innerHTML.trim() !== "") {
                dropdownMenu.style.display = "block";
            }
        });

        inputField.addEventListener("keyup", function () {
            let query = inputField.value.trim();
            if (query.length > 2) {
                fetch(`${api}?query=${query}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status == true) {
                            dropdownMenu.innerHTML = ""; // Clear previous results
                            if (api === "/admin/get-airports") {
                                const airports = data.data || []; // Ensure data array exists
                                const airportIds = data.airport_ids || [];

                                airports.forEach((airportName, index) => {
                                    let option = document.createElement("div");
                                    option.classList.add("dropdown-item");
                                    option.textContent = airportName;
                                    option.style.cursor = "pointer";

                                    option.addEventListener(
                                        "click",
                                        function () {
                                            inputField.value = airportName; // Set name in input
                                            inputField.dataset.airportId =
                                                airportIds[index]; // Store airport ID (optional)
                                            dropdownMenu.style.display = "none";
                                        }
                                    );

                                    dropdownMenu.appendChild(option);
                                });
                            } else {
                                data.locations.forEach((location, idx) => {
                                    // Use 'idx' instead of 'index'
                                    let option = document.createElement("div");
                                    option.classList.add("dropdown-item");
                                    option.textContent = location;
                                    option.style.cursor = "pointer";

                                    option.addEventListener(
                                        "click",
                                        function () {
                                            inputField.value = location; // Set location name in input
                                            inputField.dataset.cityId =
                                                data.city_ids &&
                                                data.city_ids[idx]
                                                    ? data.city_ids[idx]
                                                    : ""; // Store City ID
                                            inputField.dataset.stateId =
                                                data.state_ids &&
                                                data.state_ids[idx]
                                                    ? data.state_ids[idx]
                                                    : ""; // Store State ID
                                            dropdownMenu.style.display = "none";
                                        }
                                    );

                                    dropdownMenu.appendChild(option);
                                });
                            }

                            dropdownMenu.style.display = "block";
                        } else {
                            dropdownMenu.innerHTML = ""; // Clear previous results
                            let option = document.createElement("div");
                            option.classList.add("dropdown-item");
                            option.textContent = "no data found";
                            option.style.cursor = "pointer";
                            dropdownMenu.appendChild(option);

                            dropdownMenu.style.display = "block";
                        }
                    })
                    .catch((error) =>
                        console.error("Error fetching data:", error)
                    );
            } else {
                dropdownMenu.style.display = "none";
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (
                !inputField.contains(event.target) &&
                !dropdownMenu.contains(event.target)
            ) {
                dropdownMenu.style.display = "none";
            }
        });
    });

    function updateFormDisplay() {
        const selectedTripType = document.querySelector(
            "input[name='trip_type']:checked"
        ).value;

        if (selectedTripType === "1") {
            originField.closest(".col-sm-6").style.display = "block";
            destinationField.closest(".col-sm-6").style.display = "block";
            airportIdField.closest(".col-sm-6").style.display = "none";
            destinationTypeDiv.style.display = "none";
            airportTypeDiv.style.display = "none";
        } else if (selectedTripType === "4") {
            destinationTypeDiv.style.display = "block";
            airportTypeDiv.style.display = "block";

            updateAirportTypeDisplay();
        }
    }

    function openAddModal(event) {
        event.preventDefault();
        document.getElementById("origin").value = "";
        document.getElementById("destination").value = "";
        document.getElementById("airport_name").value = "";
        document.getElementById("car_type").value = "";
        document.getElementById("price").value = "";
        document.querySelector("input[name='trip_type'][value='1']").checked = true;
        updateFormDisplay();
        showForm(event, "pricingDiv", "Pricing", "store", "Add", "Save");
    }

    function updateAirportTypeDisplay() {
        const selectedAirportType = document.querySelector(
            "input[name='airport_type']:checked"
        ).value;

        if (selectedAirportType === "from_airport") {
            airportIdField.closest(".col-sm-6").style.display = "block";
            destinationField.closest(".col-sm-6").style.display = "block";
            originField.closest(".col-sm-6").style.display = "none";
        } else if (selectedAirportType === "to_airport") {
            airportIdField.closest(".col-sm-6").style.display = "block";
            originField.closest(".col-sm-6").style.display = "block";
            destinationField.closest(".col-sm-6").style.display = "none";
        }
    }

    updateFormDisplay();

    tripTypeRadios.forEach((radio) => {
        radio.addEventListener("change", updateFormDisplay);
    });

    airportTypeRadios.forEach((radio) => {
        radio.addEventListener("change", updateAirportTypeDisplay);
    });

    // fetchSuggestions(originField);
    // fetchSuggestions(destinationField);
    // fetchSuggestions(airportIdField);

    document.getElementById("addPricingModalBtn").addEventListener("click", openAddModal);
});



function deletePricing(id) {
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
            fetch(`/admin/fixed-pricing/${id}`, {
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