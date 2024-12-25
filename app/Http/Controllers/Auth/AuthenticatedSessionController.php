<?php
//
//namespace App\Http\Controllers\Auth;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Auth;
//
//class AuthenticatedSessionController extends Controller
//{
//    /**
//     * Handle an incoming authentication request.
//     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'phone_number' => ['required', 'string', 'max:10'],
//            'password' => ['required', 'string'],
//        ]);
//
//        if (Auth::attempt($request->only('phone_number', 'password'))) {
//            $user = Auth::user();
//            $token = $user->createToken('authToken')->plainTextToken;
//
//            return response()->json([
//                'message' => 'Login successful',
//                'user' => $user,
//                'token' => $token
//            ]);
//        }
//        return response()->json([
//            'message' => 'Invalid credentials',
//        ]);
//    }
//
//    /**
//     * Destroy an authenticated session.
//     */
//    public function destroy(Request $request): Response
//    {
//        Auth::guard('web')->logout();
//
//        $request->session()->invalidate();
//
//        $request->session()->regenerateToken();
//
//        return response()->noContent();
//    }
//}


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'phone_number' => ['required', 'string', 'min:10'],
            'password' => ['required', 'string'],
        ]);

        // Retrieve the user by phone number
        $user = User::where('phone_number', $request->phone_number)->first();

        // Check if the user exists and the password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone_number' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create a Sanctum token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
