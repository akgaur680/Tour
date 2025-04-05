<?php

namespace App\Services\Admin;

use App\Models\FixedTourPrices;
use App\Services\CoreService;

class FixedPricingServices extends CoreService
{
    public $model;
    public function __construct()
    {
        $this->model = new FixedTourPrices();
    }


    public function store(array $data)
    {
        $result = $this->model->create($data);
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Pricing Added Successfully', 'pricing' => $result]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Occured During Adding Pricing']);
        }
    }

    public function edit(int $id)
    {
        $result = $this->model->with(['originCity', 'originState', 'destinationCity', 'destinationState', 'car', 'airport'])->findorFail($id);
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Pricing Found Successfully', 'pricing' => $result]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Occured During Getting Pricing']);
        }
    }

    public function update(array $data, int $id)
{
    // Clean data based on trip_type_id
    if (isset($data['trip_type_id']) && $data['trip_type_id'] == 4) {
        // Airport trip: unset origin or destination depending on direction
        if (isset($data['airport_id'])) {
            // If origin is null, it's a "From Airport" trip
            if (empty($data['origin_city_id'])) {
                $data['origin_city_id'] = null;
                $data['origin_state_id'] = null;
                $data['origin'] = null;
            }

            // If destination is null, it's a "To Airport" trip
            if (empty($data['destination_city_id'])) {
                $data['destination_city_id'] = null;
                $data['destination_state_id'] = null;
                $data['destination'] = null;
            }
        }
    } elseif ($data['trip_type_id'] == 1) {
        // City-to-City trip: clear airport fields
        $data['airport_id'] = null;
        $data['airport'] = null;
    }

    $result = $this->model->findOrFail($id)->update($data);

    if ($result) {
        return response()->json(['status' => true, 'message' => 'Pricing Updated Successfully', 'pricing' => $result]);
    } else {
        return response()->json(['status' => false, 'message' => 'Error Occurred During Updating Pricing']);
    }
}


    public function destroy(int $id)
    {
        $result = $this->model->findorFail($id);
        if ($result) {
            $delete = $result->delete();
            if ($delete) {
                return response()->json(['status' => true, 'message' => 'Pricing Deleted Successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Occured During Deleting Pricing']);
            }
        }
        else{
            return response()->json(['status' => false, 'message' => 'Pricing Not Found']);
        }
    }
}
