function editCar(event, id){
    // event.preventDefault();

    fetch(`/admin/cars/${id}`, {
        method:"GET",
        headers:{
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if(data.status == true){
            console.log(data)
            showForm(event, 'addCarDiv')
            const car_model = document.getElementById('car_model')
            const car_number = document.getElementById('car_number')
            const car_type = document.getElementById('car_type')
            const seats = document.getElementById('seats')
            const luggage_limit = document.getElementById('luggage_limit')
            const price_per_km = document.getElementById('price_per_km')
            const ac = document.getElementById('ac')
            car_model.value = data.car.car_model 
            car_number.value = data.car.car_number
            car_type.value = data.car.car_type
            seats.value = data.car.seats
            luggage_limit.value = data.car.luggage_limit
            price_per_km.value = data.car.price_per_km
            ac.value = data.car.ac
            ac.setAttriibute('selected')
        }
    })
}