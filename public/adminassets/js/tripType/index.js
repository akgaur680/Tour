const tripTypeColumns = [
    { data: "DT_RowIndex" , title: "#" },
    { data: "name" , title: "Name"},
    { data: "slug", title: "Slug" },
   
    // {
    //     data: null,
    //     title: "Actions",
    //     render: function (data, type, row) {

    //         return `
    //             <button onclick="viewPricing(event,${row.id})" style="all: unset; cursor: pointer;">
    //                 <i class="fa fa-eye"></i>
    //             </button>
    //             <button onclick="editPricing(event,${row.id})" style="all: unset; cursor: pointer;">
    //                 <i class="fa fa-edit"></i>
    //             </button>
    //             <button onclick="deletePricing(${row.id})" style="all: unset; cursor: pointer;">
    //                 <i class="fa fa-trash-alt"></i>
    //             </button>
    //         `;
    //     },
    // },
];

InitializeTable("tripTypeTable", "/admin/trip-type", tripTypeColumns );
