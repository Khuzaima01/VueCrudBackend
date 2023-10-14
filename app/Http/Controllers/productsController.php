<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\productImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\fileExists;

class productsController extends Controller
{
    public function CreateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|image'
        ]);

        $product = product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = '/images' . $imageName;
            $imageSave = $image->move(public_path('productImages'), $imageName);

            $productImage = productImage::create([
                'image' => $imageName,
                'product_id' => $product->id,
            ]);
        }

        return response()->json([
            'product' => $request,
            'productCreatedSucc' => 'Product Created Successfully',
        ]);
    }
    public function ShowUser(Request $request)
    {
        $productData = product::with('productImage')->get();

        return response()->json([
            'product' => $productData,

        ]);
    }

    public function DeleteProduct($id)
    {

        $productImage = productImage::where('product_id', $id)->first();
        $product = product::where('id', $id)->first();
        $imageName = $productImage->image;
        $imagePath = public_path('productImages/' . $imageName);

        $productImage->delete();
        $product->delete();

        if (file_exists($imagePath)) {
            File::delete($imagePath);
        }


        return response()->json([
            'productDeletedMessage' => 'Product Deleted Successfully',
        ]);
    }


    public function EditProduct($id)
    {
        $productData = product::with('productImage')->where('id', $id)->get();


        return response()->json([
            'product' => $productData,
        ]);
    }

    public function UpdateProduct(Request $request, $id)
    {
        $productImage = productImage::where('product_id', $id)->first();
        $product = product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();


        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $oldImagePath = public_path('productImages/' . $productImage->image);
            if (File::exists($image)) {
                File::delete($oldImagePath);
            }

            $image->move(public_path('productImages/'), $imageName);
            $productImage->image = $imageName;
            $productImage->save();
        }
       
        return response()->json([
            'message' => $imageName,
        ]);
    }
}
