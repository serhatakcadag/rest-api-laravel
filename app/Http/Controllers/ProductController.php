<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
   {
     return Product::all();
   }

   public function show($id)
   {
     if (Product::find($id) == null) {
        return ['message' => "There is no such a product that match our records"];
     }
     return Product::find($id);
   }

   public function store(Request $request)
   {
      $formFields = $request->validate(
        [
            'name' => 'required',
            'price' => 'required'
        ]
      );
      if($request->description != null)
      {
        $formFields['description'] = $request->description;
      }

      Product::create($formFields);

      return ['message' => 'Product created'];
   }

   public function update(Request $request, $id)
   {

      $product = Product::find($id);

      $product->update($request->all());

      return $product;
   }

   public function delete($id)
   {

    return Product::destroy($id);
   }

   public function search($name)
   {
    return Product::where('name', 'like', '%'.$name.'%')->get();
   }
}
