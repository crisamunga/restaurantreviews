<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    /**
     * Display a listing of all restaurants that the user can see
     *
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $restaurants = null;

        if ($user->is_owner) {
            $restaurants = $user->restaurants()
                ->withSum('reviews', 'rating')
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->get();
        } else {
            $restaurants = Restaurant::withSum('reviews', 'rating')
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->get();
        }

        return RestaurantResource::collection($restaurants)->response()->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created restaurant
     *
     * @param RestaurantRequest $request
     */
    public function store(RestaurantRequest $request)
    {
        $validated = $request->validated();
        $path = $request->file('image')->store('public');

        $restaurant = new Restaurant();
        $restaurant->name = $validated['name'];
        $restaurant->image = $path;

        $user = $request->user();
        $user->restaurants()->save($restaurant);

        return (new RestaurantResource($restaurant))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Restaurant $restaurant
     */
    public function show(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant->load('reviews', 'images', 'user')
            ->loadSum('reviews', 'rating')
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews'));
    }

    /**
     * Update the specified restaurant
     *
     * @param UpdateRestaurantRequest $request
     * @param Restaurant $restaurant
     * @return RestaurantResource
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $validated = $request->validated();
        $restaurant->fill($validated);

        $uploaded = $request->file('image');
        if (isset($uploaded)) {
            $path = $uploaded->store('public');
            $restaurant->image = $path;
        }

        $restaurant->save();

        return new RestaurantResource($restaurant);
    }

    /**
     * Update the specified restaurant
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Restaurant $restaurant
     */
    public function add_image(Request $request, Restaurant $restaurant)
    {
        $restaurant->save();
        return new RestaurantResource($restaurant);
    }

    /**
     * Remove the specified restaurant
     *
     * @param Restaurant $restaurant
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->noContent();
    }
}
