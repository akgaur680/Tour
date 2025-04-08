<?php

namespace App\Services\CarService;

use App\Helpers\ImageHelper;
use App\Models\Car;
use App\Models\CarTripType;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;

class CarService extends CoreService
{
    public function store(array $data)
    {
        $tripTypeIds = $data['trip_type_ids'] ?? [];
        unset($data['trip_type_ids']);

        $carImage = $data['car_image'] ?? null;
        unset($data['car_image']);

        // Trim price_per_hour
        if (isset($data['price_per_hour'])) {
            $data['price_per_hour'] = round($data['price_per_hour']);

        }
        if ($carImage) {
            $data['car_image'] = ImageHelper::storeImage($carImage, 'cars');
        }

        $car = Car::create($data);

        if ($car) {
            // Sync trip types to pivot table
            foreach ($tripTypeIds as $tripTypeId) {
                $car->carTripTypes()->create([
                    'trip_type_id' => $tripTypeId,
                ]);
            }


            return response()->json(['status' => true, 'message' => 'Car Added Successfully', 'car' => $car]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Occurred During Adding Car']);
        }
    }


    public function edit(int $id)
    {
        $car = Car::with('carTripTypes.tripType')->findorFail($id);
        if ($car) {
            return response()->json(['status' => true, 'car' => $car]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Occured During Getting Car Details']);
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        $car = Car::findorFail($id);
        if (!$car) {
            return response()->json(['status' => false, 'message' => 'Car Not Found']);
        }

        // Trim price_per_hour
        if (isset($data['price_per_hour'])) {
            $data['price_per_hour'] = round($data['price_per_hour']);

        }
        $carImage = $data['car_image'] ?? null;
        unset($data['car_image']);

        // Remove trip_type_ids before update if it's a relation
        $tripTypeIds = $data['trip_type_ids'] ?? null;
        unset($data['trip_type_ids']);


        // Check if car_image is present in the request
        if ($carImage) {
            $data['car_image'] = ImageHelper::updateImage($carImage, $car->car_image, 'cars'); // Pass old image path
        }

        $update = $car->update($data);
        if ($update) {
            // Remove existing trip types manually from pivot table
            $tripTypes = CarTripType::where('car_id', $car->id)->delete();

            // Re-insert new trip types
            foreach ($tripTypeIds as $tripTypeId) {
                $addTripType = CarTripType::create([
                    'car_id' => $car->id,
                    'trip_type_id' => $tripTypeId,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Car Updated Successfully',
                'car' => $car,
            ]);
        } else {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Error Occurred During Updating Car']);
        }
    }
}
