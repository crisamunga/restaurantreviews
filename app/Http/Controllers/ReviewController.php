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
        return ReviewResource::collection(Review::all());
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

        return (new ReviewResource($review))->response()->setStatusCode(201);
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
        return new ReviewResource($review);
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

        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     */
    public function show(Review $review)
    {
        return new ReviewResource($review);
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
