<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Return currently logged in user
     *
     */
    public function index(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update currently logged in user details
     *
     * @param ProfileRequest $request
     */
    public function store(ProfileRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        $user->fill($validated);

        $uploaded = $request->file('image');
        if (isset($uploaded)) {
            $path = $uploaded->store('public');
            $user->image = $path;
        }

        $user->save();
        return new UserResource($user);
    }
}
