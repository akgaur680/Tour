<?php

namespace App\Services\CarService;

use App\Helpers\ImageHelper;
use App\Models\CarModel;
use App\Services\CoreService;

class CarService extends CoreService
{
    public function store(array $data)
    {
        try {
            $carImage = $data['car_image'] ?? null;
            unset($data['car_image']);
    
            if ($carImage) {
                $data['car_image'] = ImageHelper::storeImage($carImage, 'cars');
            }
    
            $car = CarModel::create($data);
    
            return response()->json([
                'status' => true,
                'message' => 'Car Added Successfully',
                'car' => $car
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while adding the car.',
                'error' => $e->getMessage() // Remove this in production for security
            ], 500);
        }
    }
    
    public function edit(int $id)
    {
        $car = CarModel::findorFail($id);
        if ($car) {
            return response()->json(['status' => true, 'car' => $car]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Occured During Getting Car Details']);
        }
    }

    public function update(array $data, int $id)
    {
        $car = CarModel::findOrFail($id); // Corrected 'findorFail()' to 'findOrFail()'
        $carImage = $data['car_image'] ?? null;
        unset($data['car_image']);

        if ($carImage) {
            $data['car_image'] = ImageHelper::updateImage($carImage, $car->car_image, 'cars'); // Pass old image path
        }

        $update = $car->update($data);

        return response()->json([
            'status' => (bool) $update,
            'message' => $update ? 'Car Updated Successfully' : 'Error in Updating Car',
        ]);
    }
}
