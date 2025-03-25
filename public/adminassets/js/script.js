function showForm(event, divId, type) {
    event.preventDefault();
    const div = document.getElementById(divId);
    if (!div) {
        console.error("Element not found:", divId);
        return;
    }
    if (type === 'store') {
        const form = div.querySelector('form');
        if (form) {
            form.reset();
        }
    }
    // const div = document.getElementById(divId);
    if (div.style.display == "none") {
      div.style.display = "block";
    } else {
      div.style.display = "none";
    }
    window.onclick = function (event) {
      if (event.target == div) {
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
    document.addEventListener('DOMContentLoaded', function () {
    

        dataTable = new DataTable(`#${id}`, {
            ajax: {
                url: `${url}`, // Replace with your Laravel route
                dataSrc: "data",
            },
            columns: columns
        });
    });
}