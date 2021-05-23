<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Api\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function show(int $id)
    {
        try {
            $user = $this->user->with('profile')->findOrFail($id);

            $user->profile->social_networks = unserialize($user->profile->social_networks);

            return response()->json([
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'phone' => 'required'
        ])->validate();

        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);

            $user->profile()->create([
                'phone' => $data['phone']
            ]);

            return response()->json(['data' => ['status' => 'success', 'user' => $user]]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        if ($request->has('password') && $request->get('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        Validator::make($data, [
            'profile.phone' => 'required',
            'profile.social_networks' => 'required'
        ])->validate();
        try {
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = $this->user->findOrFail($id);
            $user->update($data);

            $user->profile()->update($profile);
            return response()->json(['data' => ['message' => 'Usuário atualizado com sucesso!']], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }

    }
}
