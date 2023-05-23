<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'mobile' => 'required|numeric|digits:10',
                'otp' => 'required|digits:6',
            ]);

            // Check OTP generated or not.
            $mobile = Otp::where('mobile', $request->mobile)->first();

            if (! $mobile) {
                return response()->json(['error' => 'OTP not generated. Please refresh the page and try again.']);
            }

            // Verify the OTP here
            $otp = Otp::where('mobile', $request->mobile)
                ->where('otp', $request->otp)
                ->where('expire_at', '>=', now()->timestamp)
                ->orderByDesc('id')
                ->first();

            if (! $otp) {
                return response()->json(['error' => 'OTP expired, please enter latest one.']);
            }

            // If OTP verification is successful, find or create the user
            $user = User::where('mobile', $request->mobile)->first();
            if (! $user) {
                $user = User::create([
                    'mobile' => $request->mobile,
                ]);
            }

            // Delete OTP. So that they can use only once
            $otp = Otp::where('otp', $otp->otp)->delete();

            // Generate Sanctum token for the user
            $token = $user->createToken($request->mobile)->plainTextToken;

            return response()->json(['bearer_token' => $token]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateOtp(Request $request)
    {
        try {
            $request->validate([
                'mobile' => 'required|numeric|digits:10',
            ]);

            $random_otp = random_int(100000, 999999);

            $otp = Otp::create([
                'mobile' => $request->mobile,
                'otp' => $random_otp,
                'expire_at' => now()->addSeconds(60)->timestamp,
            ]);

            if (! $otp) {
                return response()->json(['error' => 'Please refresh the page and try again.']);
            }

            return response()->json(
                [
                    'success' => 'OTP generated successfully.',
                    'otp' => $otp->otp,
                ]
            );
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
