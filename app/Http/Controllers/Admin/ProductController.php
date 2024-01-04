<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    public function create() : View
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(ProductCreateRequest $request)
    {
        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image');

        $product = new Product();
        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = generateUniqueSlug('Product', $request->name);
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;
        $product->save();

        toastr()->success('Create Successfully');

        return to_route('admin.product.index');
    }

    public function edit(string $id) : View
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('categories', 'product'));
    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        //
                $product = Product::findOrFail($id);

                /** Handle image file */
                $imagePath = $this->uploadImage($request, 'image', $product->thumb_image);

                $product->thumb_image = !empty($imagePath) ? $imagePath : $product->thumb_image;
                $product->name = $request->name;
                $product->slug = generateUniqueSlug('Product', $request->name);
                $product->category_id = $request->category;
                $product->price = $request->price;
                $product->offer_price = $request->offer_price;
                $product->short_description = $request->short_description;
                $product->long_description = $request->long_description;
                $product->sku = $request->sku;
                $product->seo_title = $request->seo_title;
                $product->seo_description = $request->seo_description;
                $product->show_at_home = $request->show_at_home;
                $product->status = $request->status;
                $product->save();

                toastr()->success('Update Successfully');

                return to_route('admin.product.index');
    }

    public function destroy(string $id) : Response
    {
        //
        try{
            $product = Product::findOrFail($id);
            $this->removeImage($product->thumb_image);
            $product->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}
