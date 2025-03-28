<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\CoreService;
use Carbon\Carbon;

class AuthByMobile extends CoreService
{
    public function register(array $data)
    {
        $otp = rand(100000, 999999);
        $user = User::where('mobile_no', $data['mobile_no'])->first();
        $smsResponse = null;

        if ($user) {
            if ($user->mobile_verified) {
                return response()->json(['status' => true, 'message' => "$user->role Already Registered. Please Login"]);
            } else {
                $user->update(['otp' => $otp, 'otp_expiry' => Carbon::now()->addMinutes(15)]);
                $message = "Here is the OTP for Verification. Your OTP code is : $otp";
                $smsResponse = $this->sendSMS($user->mobile_no, $message, 'Verification');
            }
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile_no' => $data['mobile_no'],
                'otp' => $otp,
                'role' => $data['role'],
                'otp_expiry' => Carbon::now()->addMinutes(15),
                'mobile_verified' => false
            ]);

            $message = "Here is the OTP for Registration. Your OTP code is : $otp";
            $smsResponse = $this->sendSMS($user->mobile_no, $message, 'Registration');
          
        }
        if ($smsResponse->sid) {
            return response()->json(['status' => true, 'message' => 'Otp Sent Successfully. Valid for 15 Minutes']);
        } else {
            return response()->json(['status' => false, 'message' => 'Error in Sending OTP']);
        }
    }

    public function login(array $data)
    {
        $otp = rand(100000, 999999);
        $user = User::where('mobile_no', $data['mobile_no'])->first();
        $smsResponse = null;
        if ($user) {
            $user->update(['otp' => $otp, 'otp_expiry' => Carbon::now()->addMinutes(15)]);
            $message = "Here is the OTP for Login. Your OTP code is : $otp";
            $smsResponse = $this->sendSMS($user->mobile_no, $message, 'Login');
        } else {
            return response()->json(['status' => false, 'message' => 'User Not Registered. Please Register First']);
        }
        if ($smsResponse) {
            return response()->json(['status' => true, 'message' => 'Otp Sent Successfully. Valid for 15 Minutes']);
        } else {
            return response()->json(['status' => false, 'message' => 'Error in Sending OTP']);
        }
        // if ($smsResponse->sid) {
        //     return response()->json(['status' => true, 'message' => 'Otp Sent Successfully. Valid for 15 Minutes']);
        // } else {
        //     return response()->json(['status' => false, 'message' => 'Error in Sending OTP']);
        // }
    }

    public function otpVerify(array $data)
    {
        $user = User::where('mobile_no', $data['mobile_no'])->first();
     
        if (!$user || $user->otp != $data['otp']) {
            return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
        }

        if ($user->otp_expiry < Carbon::now()) {
            return response()->json(['status' => false, 'message' => 'OTP Expired'], 400);
        }
        
        // OTP is valid → Verify user, generate access token & login
        $user->update(['mobile_verified' => true, 'otp' => null, 'otp_expiry' => null]);
        // Generate Passport access token
       
        $token = $user->createToken('authToken')->accessToken;
<<<<<<< HEAD
        // dd($token);
=======
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
   
        return response()->json([
            'status' => true,
            'message' => 'OTP Verified Successfully. Login Successful',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
