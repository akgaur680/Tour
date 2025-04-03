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
        $result = $this->model->findorFail($id)->update($data);
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Pricing Updated Successfully', 'pricing' => $result]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error Occured During Updating Pricing']);
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
