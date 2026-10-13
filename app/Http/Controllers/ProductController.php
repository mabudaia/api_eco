<?php

namespace App\Http\Controllers;
use App\Models\Category;

use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
class ProductController extends Controller
{
    public function index()
{
    $products=Auth::user()->products;
    return response()->json($products, 200);
}


 public function getAllProduct()
 {
    $product = Product::all();
    return response()->json($product, 200);
 }


public function store(StoreProductRequest $request)
{
    $user_id=Auth::user()->id;
    $validatedData=$request->validated();
    $validatedData['user_id']=$user_id;

           if($request->hasFile('image')){
           $path= $request->file('image')->store('my photo','public');
            $validatedData['image']=$path;
         }
    $product = Product::create($validatedData);
    return response()->json($product, 201);
}

public function show(Product $product)
{
    return response()->json($product, 200);
}

public function update(Request $request, Product $product)
{
    $product->update($request->all());
    return response()->json($product, 200);
}



public function addCategoryToProduct(Request $request,$productId){
   $product= Product::findorFail($productId);
   $product->categories()->attach($request->category_id);//نرفق اكتر من تصنيف بالاتتش نبعت جواتها التصنيف الي ببعتو المستخدم
return response()->json('category atteched succssfully',200);

}

public function getCategoryProducts(Request $request,$categoryId){
    $products=Category::findorFail($categoryId)->products;
return response()->json($products,200);
}

    public function destroy(Product $product)
{
    $product->delete();
    return response()->json(null, 204);
}
public function applyDiscount(Request $request, Product $product)
{
    $data = $request->validate([
        'discount' => 'required|numeric|min:0|max:100'
    ]);

    $product->update(['discount' => $data['discount']]);

    return response()->json([
        'message' => 'تم تطبيق الخصم بنجاح',
        'product' => $product,
        'price_after_discount' => $product->price_after_discount
    ]);
}

}
