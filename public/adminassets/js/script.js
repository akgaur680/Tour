
let dataTable;
// Initialize DataTable
function InitializeTable(id, url, columns) {
    dataTable = new DataTable(`#${id}`, {
        ajax: {
            url: `${url}`,
            dataSrc: "data",
        },
        columns: columns,
    });
}


function reloadTableWithRetry(retries = 10, delay = 300) {
    if (typeof dataTable !== "undefined" && dataTable !== null) {
        console.log(dataTable);
        dataTable.ajax.reload(null, false);
    } else if (retries > 0) {
        setTimeout(() => reloadTableWithRetry(retries - 1, delay), delay);
    } else {
        console.error("DataTable is not initialized after waiting.");
    }
}


function showForm(
    event,
    divId,
    entity,
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

    const form = div.querySelector("form");
    clearErrors(); // Clear previous errors
    if (form) {
        form.reset(); // Reset form fields
        form.method = type === "store" ? "POST" : "PUT"; // Use PUT for edit
        form.setAttribute("action", `/admin/${entity}`);
    }

    // Set title and button text dynamically
    const titleElement = div.querySelector(".modal-title, .form-title, #div-title");
    if (titleElement) {
        titleElement.textContent = type === "edit" ? "Edit" : defaultTitle;
    }

    const buttonElement = div.querySelector('button[type="submit"], .modal-btn, #submitBtn');
    if (buttonElement) {
        buttonElement.textContent = type === "edit" ? "Update" : defaultButtonText;
        buttonElement.removeAttribute('onclick');
        if (type === "store") {
            buttonElement.setAttribute('onclick', `add${entity}(event);`);
        }
    }

    // Reset Image Previews for "store" mode
    if (type === "store") {
        const imageElements = div.querySelectorAll(".img_preview");
        imageElements.forEach((img) => {
            img.src = "/adminassets/dist/img/defaultImage.avif"; // Set default image
            img.style.display = "none"; // Hide the image
        });
    }

    // Show the form
    div.style.display = "block";

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

function showValidationErrors(errors) {
    errors.forEach(error => {
        const inputField = document.getElementById(error.field);
        if (inputField) {
            let errorSpan = document.createElement("span");
            errorSpan.className = "error-message";
            errorSpan.style.color = "red";
            errorSpan.style.fontSize = "12px";
            errorSpan.textContent = error.message;

            inputField.classList.add("input-error"); // Highlight the input
            inputField.parentNode.appendChild(errorSpan); // Append error message
        }
    });
}

function clearErrors() {
    document.querySelectorAll(".error-message").forEach(error => error.remove());
    document.querySelectorAll(".input-error").forEach(input => input.classList.remove("input-error"));
}

