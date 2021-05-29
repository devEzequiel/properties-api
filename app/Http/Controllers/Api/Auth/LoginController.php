<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\newLogin;
use App\Models\Api\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
/**
 * @var User
 */
private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request) 
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        
            $this->user = User::where('email', $request->email)->first();

            if (! $this->user || ! Hash::check($request->password, $this->user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            Mail::send(new newLogin($this->user->id, $this->user->email, $this->user->name));
            $token = $this->user->createToken($request->email)->plainTextToken;
    
            return response()->json(['data' => ['status' => 'success', 'token' => $token]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
        
    }

    public function logout (Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['msg' => 'success'], 200);
    }

    public function removeAllTokensFromCurrentUser ($id)
    {
        try {
            Auth::user()->tokens()->delete();
            return response()->json([
                 'status' => "success"
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}