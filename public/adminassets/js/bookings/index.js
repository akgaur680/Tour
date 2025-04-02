const bookingColumn = [
    {data:'DT_RowIndex', title: '#'},
    {data:'user.name', title: 'Customer Name'},
    {data:'user.mobile_no', title: 'Customer Mobile No'},
    {data:'pickup_location', title: 'Pickup Location'},
    {data:'drop_location', title: 'Drop Location'},
    {data:'pickup_date', title: 'Pickup Date'},
    {data:'pickup_time', title: 'Pickup Time'},
    {data:'drop_date', title: 'Drop Date'},
    {data:'drop_time', title: 'Drop Time'},
    {data:'status', title: 'Status'},
    {data:'actions', title: 'Actions', 
        render: function (data, type, row) {
            return `
                <button onclick="viewBooking(${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-eye"></i>
                </button>
                <button onclick="editBooking(${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-edit"></i>
                </button>
                <button onclick="deleteBooking(${row.id})" style="all: unset; cursor: pointer;">
                    <i class="fa fa-trash-alt"></i>
                </button>
            `;
        },
    }
]