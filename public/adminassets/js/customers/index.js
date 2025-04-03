const customerTable = [
    {data : "DT_RowIndex", title: "#"},
    {data : "name", title: "Name"},
    {data : "email", title: "Email"},
    {data : "mobile_no", title: "Mobile No"},
    {data : "created_at", title: "Created At"},
    {
        data: null,
        title: "Actions",
        render: function (data, type, row) {
            return `
                <button onclick="viewCustomer(event,${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-eye"></i>
                </button>
               
            `;
        },
    },
]

InitializeTable("customerTable", "/admin/customers", customerTable);