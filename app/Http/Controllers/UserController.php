<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|object
     *
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse|object
     */
    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User($validated);
        $user->is_admin = $validated['is_admin'];

        $uploaded = $request->file('image');
        if (isset($uploaded)) {
            $path = $uploaded->store('public');
            $user->image = $path;
        }

        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return JsonResponse|object
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return JsonResponse|object
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill($validated);
        if (isset($validated['is_admin'])) {
            $user->is_admin = $validated['is_admin'];
        }

        $uploaded = $request->file('image');
        if (isset($uploaded)) {
            $path = $uploaded->store('public');
            $user->image = $path;
        }

        $user->save();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
