const verifyPaymentColumn = [
    { data: 'DT_RowIndex', title: '#' },
    { data: 'user.name', title: 'Customer Name' },
    { data: 'pickup_location', title: 'Pickup Location' },
    { data: 'drop_location', title: 'Drop Location' },
    { data: 'pickup_date', title: 'Pickup Date' },
    { data: 'payment_status', title: 'Payment Status'},
    { data: 'booking_status', title: 'Booking Status', 
        render: function (data, type, row) {
            let status = '';
            if (row.booking_status == 'upcoming') {
                status = '<span class="badge badge-warning">Up-Coming</span>';
            } else if (row.booking_status == 'ongoing') {
                status = '<span class="badge badge-info">On-Going</span>';
            } else if (row.booking_status == 'completed') {
                status = '<span class="badge badge-success">Completed</span>';
            } else if (row.booking_status == 'cancelled') {
                status = '<span class="badge badge-danger">Cancelled</span>';
            }
            return status;
        }

     },
     { data: 'total_amount', title: 'Total Amount' },
     {
        data: 'received_amount',
        title: 'Paid Amount',
        render: function (data, type, row) {
            return data ? data : 0.00;
        }
    },
    {
        data: 'action',
        title: 'Action',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
            return `<button type="button" onclick="viewPayment(event,${row.id})" class="btn  btn-sm"><i class="fas fa-eye"></i></button>
            <button type="button" onclick="verifyPayment(event,${row.id})" class="btn btn-primary btn-sm">Verify Payment</button>`;
        }
    }
    ];

InitializeTable('verifyPaymentTable', '/admin/verify-payments', verifyPaymentColumn);
