<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewReplyRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Review::class, 'review');
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return ReviewResource::collection(Review::with('user', 'restaurant')->get())->response()->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * Validate and store a newly created review.
     *
     * @param ReviewRequest $request
     */
    public function store(ReviewRequest $request)
    {
        $validated = $request->validated();

        $review = new Review($validated);
        $user = $request->user();
        $user->reviews()->save($review);

        return (new ReviewResource($review->load('user', 'restaurant')))->response()->setStatusCode(201);
    }

    /**
     * Validate and store a newly created review.
     *
     * @param ReviewRequest $request
     * @param Review $review
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $validated = $request->validated();

        $review->fill($validated);
        $user = $request->user();
        $user->reviews()->save($review);

        return new ReviewResource($review->load('user', 'restaurant'));
    }

    /**
     * Removes a comment from a review
     *
     * @param Review $review
     */
    public function uncomment(Review $review) {
        $this->authorize('uncomment', $review);
        $review->comment = "Deleted";
        $review->save();
        return new ReviewResource($review->load('user', 'restaurant'));
    }

    /**
     * Removes a comment from a review
     *
     * @param Review $review
     */
    public function reply(ReviewReplyRequest $request, Review $review) {
        $this->authorize('reply', $review);

        $validated = $request->validated();
        $review->reply = $validated['reply'];
        $review->replied_on = now();
        $review->save();

        return new ReviewResource($review->load('user', 'restaurant'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     */
    public function show(Review $review)
    {
        return new ReviewResource($review->load('user', 'restaurant'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->noContent();
    }
}
