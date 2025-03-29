function showForm(
    event,
    divId,
    type,
    defaultTitle = "Add New",
    defaultButtonText = "Save"
) {
    event.preventDefault();
    const div = document.getElementById(divId);
    if (!div) {
        console.error("Element not found:", divId);
        return;
    }

    if (type === "store") {
        const form = div.querySelector("form");
        if (form) {
            form.reset(); // Reset form fields
            form.method = "POST";
            form.setAttribute("action", "/admin/cars");

        }

        // Reset title dynamically based on modal structure
        const titleElement = div.querySelector(
            ".modal-title, .form-title, #car-title"
        );
        if (titleElement) {
            titleElement.textContent = defaultTitle; // Set dynamic default title
        }

        // Reset button text dynamically
        const buttonElement = div.querySelector(
            'button[type="submit"], .modal-btn, #addCarBtn'
        );
        if (buttonElement) {
            buttonElement.textContent = defaultButtonText; // Set dynamic default button text
        }
    }

    // Toggle form visibility
    div.style.display =
        div.style.display === "none" || div.style.display === ""
            ? "block"
            : "none";

    // Close form when clicking outside
    window.onclick = function (event) {
        if (event.target === div) {
            div.style.display = "none";
        }
    };
}

function closeDiv(event, divId) {
    const div = document.getElementById(divId);
    div.style.display = "none";
}

let dataTable;
// Initialize DataTable
function InitializeTable(id, url, columns) {
    document.addEventListener("DOMContentLoaded", function () {
        dataTable = new DataTable(`#${id}`, {
            ajax: {
                url: `${url}`, // Replace with your Laravel route
                dataSrc: "data",
            },
            columns: columns,
        });
    });
}
