<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'desc')->get();

        return inertia('Reviews/Index', [
            'reviews' => $reviews,
        ]);
    }

    public function create(Order $order)
    {
        return inertia('Reviews/Create', [
            'csrfToken' => csrf_token(),
            'order_id' => $order->id,
        ]);
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'rating' => 'required',
            'atmosphere_rating' => 'required',
            'service_rating' => 'required',
            'favorite_food' => 'nullable|string|max:1000',
            'improvement_suggestions' => 'nullable|string|max:1000',
        ]);

        $review = new Review();
        $review->order_id = $order->id;
        $review->name = $request->input('name', 'Anoniem');
        $review->rating = $request->input('rating');
        $review->atmosphere_rating = $request->input('atmosphere_rating');
        $review->service_rating = $request->input('service_rating');
        $review->favorite_food = $request->input('favorite_food');
        $review->improvement_suggestions = $request->input('improvement_suggestions');
        $review->save();

        return inertia('Reviews/Create', [
            'stored' => true
        ]);
    }
}
