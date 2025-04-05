driverRequestColumn = [
    {data: 'DT_RowIndex', title: '#'},
    {data: 'user.name', title: 'Driver Name'},
    {data: 'user.email', title: 'Driver Email'},
    {data: 'user.mobile_no', title: 'Driver Mobile No'},
    {
        data: 'user.address',
        title: 'Driver Address',
        render: function(data, type, row) {
          return row.user && row.user.address ? row.user.address : 'N/A';
        }
      },
      
    {data: 'actions', title: 'Actions', orderable: false, searchable: false,
        render: function (data, type, row) {
            return `
                <button type="button" onclick="viewDriverRequest(event,${row.id})"style="all: unset; cursor: pointer;"><i class="fa fa-eye"></i></button>
                <button type="button" onclick="submitApprovalStatus(event, ${row.id})"style="all: unset; cursor: pointer;"><i class="fa fa-check"></i></button>
              
            `;
        }
    },
]

InitializeTable('driverRequestTable', '/admin/driver-requests', driverRequestColumn);   