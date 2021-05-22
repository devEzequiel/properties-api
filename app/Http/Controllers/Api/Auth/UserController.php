<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Api\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    /**
     * Create a new controller instance
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login()
    {

    }

    public function store(UserRequest $request)
    {


        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = Hash::make($request->password);

        $this->user->save();

        return response()->json(['status' => 'success', 'user' => $this->user]);
    }
}
