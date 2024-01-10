<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(): View
    {
        $sliders = Slider::where('status', 1)->get();

        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();

        return view(
            'frontend.home.index',
            compact(
                'sliders',
                'categories'
            )
        );
    }

    function showProduct(string $slug): View
    {
        $product = Product::with(['productImages', 'productSizes', 'productOptions'])
            ->where(['slug' => $slug, 'status' => 1])
            ->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->latest()
            ->get();

        return view('frontend.pages.product-view', compact('product', 'relatedProducts'));
    }
}
