<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGalleryStoreRequest;
use App\Models\ProductGallery;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ProductGalleryController extends Controller
{
    use FileUploadTrait;

    public function index(string $productId) : View
    {
        return view('admin.product.gallery.index', compact('productId'));
    }

    public function store(ProductGalleryStoreRequest $request) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');

        $gallery = new ProductGallery();
        $gallery->product_id = $request->product_id;
        $gallery->image = $imagePath;
        $gallery->save();

        toastr()->addSuccess('Created Successfully!');

        return redirect()->back();
    }

    public function destroy(string $id) : Response
    {
        try{
            $image = ProductGallery::findOrFail($id);
            $this->removeImage($image->image);
            $image->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
