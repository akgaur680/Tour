<?php

namespace App\Services\CarService;

use App\Models\CarModel;
use App\Services\CoreService;

class CarService extends CoreService
{
    public function store(array $data){
        $car = CarModel::create($data);
        
        if($car){
            return response()->json(['status'=> true, 'message' => 'Car Added Successfully', 'car' => $car]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Adding Car']);
        }
    }
}