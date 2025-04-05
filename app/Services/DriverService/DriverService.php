<?php

namespace App\Services\DriverService;

use App\Helpers\ImageHelper;
use App\Models\Driver;
use App\Models\User;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;

class DriverService extends CoreService
{
    public function store(array $data){
        $profileImage = $data['profile_image'] ?? null;
        $licenseImage = $data['license_image'] ?? null;
        $adhaarImageFront = $data['adhaar_image_front'] ?? null;
        $adhaarImageBack = $data['adhaar_image_back'] ?? null;
        unset($data['license_image']);
        unset($data['adhaar_image_front']);
        unset($data['adhaar_image_back']);
        unset($data['profile_image']);

        if ($profileImage) {
            $data['profile_image'] = ImageHelper::storeImage($profileImage, 'users');
        }
        if ($licenseImage) {
            $data['license_image'] = ImageHelper::storeImage($licenseImage, 'drivers/licenses');
        }
        if ($adhaarImageFront) {
            $data['adhaar_image_front'] = ImageHelper::storeImage($adhaarImageFront, 'drivers/adhaar/front');
        }
        if ($adhaarImageBack) {
            $data['adhaar_image_back'] = ImageHelper::storeImage($adhaarImageBack, 'drivers/adhaar/back');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'mobile_verified' => true,
            'dob' => $data['dob'],
            'address' => $data['address'],
            'profile_image' => $data['profile_image'],
        ]);
        $driver = Driver::create([
            'user_id' => $user->id,
            'car_id' => $data['car_id'],
            'driving_license' => $data['driving_license'],
            'license_expiry' => $data['license_expiry'],
            'license_image' => $data['license_image'],
            'adhaar_number' => $data['adhaar_number'],
            'adhaar_image_front' => $data['adhaar_image_front'],
            'adhaar_image_back' => $data['adhaar_image_back'],
            'is_approved' => $data['is_approved'] ?? true,
            'is_available' => $data['is_available'] ?? true,
        ]);

        if($driver){
            return response()->json(['status'=> true, 'message' => 'Driver Added Successfully', 'driver' => $driver]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Adding Driver']);
        }
    }

    public function edit(int $id){
        $driver = Driver::findorFail($id)->with('user', 'car')->first();
        if($driver){
            return response()->json(['status'=> true, 'driver' => $driver]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Getting Driver Details']);
        }
       
    }

    public function update(array $data, int $id){

        DB::beginTransaction();
        $driver = Driver::findOrFail($id);
    
        // Extract and process images before unsetting them
        $profileImage = $data['profile_image'] ?? null;
        $licenseImage = $data['license_image'] ?? null;
        $adhaarImageFront = $data['adhaar_image_front'] ?? null;
        $adhaarImageBack = $data['adhaar_image_back'] ?? null;
    
        if ($profileImage) {
            $data['profile_image'] = ImageHelper::updateImage($profileImage, $driver->user->profile_image ?? null, 'users');
        }
        if ($licenseImage) {
            $data['license_image'] = ImageHelper::updateImage($licenseImage, $driver->license_image ?? null, 'drivers/licenses');
        }
        if ($adhaarImageFront) {
            $data['adhaar_image_front'] = ImageHelper::updateImage($adhaarImageFront, $driver->adhaar_image_front ?? null, 'drivers/adhaar/front');
        }
        if ($adhaarImageBack) {
            $data['adhaar_image_back'] = ImageHelper::updateImage($adhaarImageBack, $driver->adhaar_image_back ?? null, 'drivers/adhaar/back');
        }
    
        // Now unset image keys to avoid errors when updating DB
        unset($data['profile_image'], $data['license_image'], $data['adhaar_image_front'], $data['adhaar_image_back']);
    
        // Update User Details
        $user = User::findOrFail($driver->user_id);
        $userUpdate = $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'dob' => $data['dob'],
            'address' => $data['address'],
            'profile_pic' => $data['profile_image'] ?? $user->profile_pic, // Keep old image if not updated
        ]);
    
        if (!$userUpdate) {
            return response()->json(['status' => false, 'message' => 'Error Occurred During Updating User Details']);
        }   
    
        // Update Driver Details
        $update = $driver->update([
            'car_id' => $data['car_id'],
            'license_expiry' => $data['license_expiry'],
            'license_image' => $data['license_image'] ?? $driver->license_image, // Keep old if null
            'adhaar_image_front' => $data['adhaar_image_front'] ?? $driver->adhaar_image_front, // Keep old if null
            'adhaar_image_back' => $data['adhaar_image_back'] ?? $driver->adhaar_image_back, // Keep old if null
            'is_approved' => $data['is_approved'] ?? true,
            'is_available' => $data['is_available'] ?? true,
        ]);
    
        if ($update) {
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Driver Updated Successfully']);
        } else {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Error in Updating Driver']);
        }
    }

    public function destroy(int $id){
        $driver = Driver::findOrFail($id);
        if($driver){
            // $user = User::findOrFail($driver->user_id);
            // $user->delete();
            $driver->delete();
            return response()->json(['status' => true, 'message' => 'Driver Deleted Successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Deleting Driver']);
        }
    }

    public function toggleAvailability($request, $id){
        
        $driver = Driver::findOrFail($id);
        $driver->is_available = $request->is_available;
        $driver->save();

        return response()->json(['status' => true]);
    }

    public function toggleApproval($request, $id){
        
        $driver = Driver::findOrFail($id);
        $driver->is_approved = $request->is_approved;
        $driver->save();

        return response()->json(['status' => true]);
    }
    
}