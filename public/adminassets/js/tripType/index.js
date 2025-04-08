const tripTypeColumns = [
    { data: "DT_RowIndex" , title: "#" },
    { data: "name" , title: "Name"},
    { data: "slug", title: "Slug" },
   
];

InitializeTable("tripTypeTable", "/admin/trip-type", tripTypeColumns );
