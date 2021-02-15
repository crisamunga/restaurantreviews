<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Authenticates the user and issues an auth token
     *
     * @param LoginRequest $request
     * @throws ValidationException
     */
    public function login(LoginRequest $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return response()->json(['data' => ['token' => $token, 'user' => $user]], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Registers a new user to the system
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function register(RegisterRequest $request) {
        $validated = $request->validated();

        $user = new User($validated);

        $uploaded = $request->file('image');
        if (isset($uploaded)) {
            $path = $uploaded->store('public');
            $user->image = $path;
        }

        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Revokes the token the user is currently using
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
