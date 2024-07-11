<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class ReviewController extends Controller
{


    public function index($productId)
    {
        try {
            $product = Product::with('reviews')->findOrFail($productId);
        } catch (\Exception $e) {
            return $this->error('no product found', [], 404);
        }


        if ($product->reviews() && $product->reviews()->count() > 0) {
             $reviews = $product->reviews()->orderBy('created_at', 'desc')->get();
            return $this->success(  ReviewResource::collection($reviews), '', true, 200);
        }
        return $this->success([], 'there is no reviews yet', 200);

    }


    public function store(ReviewRequest $request, $productId)
    {

        try {
            $product = Product::findOrFail($productId);
        } catch (\Exception $e) {
            return $this->error('no product found', [], 404);
        }

        $review = new Review([
            'title' => $request->title,
            'body' => $request->body,
            'rating' => $request->rating,
        ]);

        $product->reviews()->save($review);
        return $this->success(new ReviewResource($review), '', 200);


    }

    /**
     * Display the specified review.
     *
     * @param int $productId
     * @param int $reviewId
     * @return \Illuminate\Http\Response
     */
    public function show($productId, $reviewId)
    {
        try {
            $review = Review::with('product')->where('product_id', $productId)
                ->findOrFail($reviewId);

            return $this->success(new ReviewResource($review), '', 200);

        } catch (\Exception $e) {
            return $this->error('no review found', [], 404);
        }
    }

    /**
     * Update the specified review in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @param int $reviewId
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, $productId, $reviewId)
    {

        try {
            $review = Review::where('product_id', $productId)
                ->findOrFail($reviewId);

            $review->title = $request->title;
            $review->body = $request->body;
            $review->rating = $request->rating;
            $review->save();

//            return new ReviewResource($review);
            return $this->success(new ReviewResource($review), '', 200);


        } catch (\Exception $e) {
            return $this->error('no review found', [], 404);
        }
    }

    /**
     * Remove the specified review from storage.
     *
     * @param int $productId
     * @param int $reviewId
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId, $reviewId)
    {
        try {
            $review = Review::where('product_id', $productId)
                ->findOrFail($reviewId);

            $review->delete();

            return response()->json(['message' => 'Review deleted successfully']);

        } catch (\Exception $e) {
            return $this->error('no review found', [], 404);
        }
    }
}
