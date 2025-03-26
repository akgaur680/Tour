<?php

namespace App\Services\CarService;

use App\Models\CarModel;
use App\Services\CoreService;

class CarService extends CoreService
{
    public function store(array $data){
        // $data = $data->except('car_image');
        // if ($data->hasFile('car_image')) {
        //     $imagePath = $data->file('car_image')->store('cars', 'public'); // Store in storage/app/public/cars
        //     $data['car_image'] = $imagePath;
        // }
        $car = CarModel::create($data);

        if($car){
            return response()->json(['status'=> true, 'message' => 'Car Added Successfully', 'car' => $car]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Adding Car']);
        }
    }

    public function edit(int $id){
        $car = CarModel::findorFail($id);
        if($car){
            return response()->json(['status'=> true, 'car' => $car]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Getting Car Details']);
        }
    }

    public function update(array $data, int $id){
        $car = CarModel::findorFail($id);
        $update = $car->update($data);
        if ($update) {
            return response()->json(['status' => true, 'message' => 'Car Updated Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Error in Updating Car']);
        }
    }

    
}