<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class productController extends Controller
{

  // web base work with blade engine



  // handle to get all products
  public function index()
  {
    $products = Product::where('status', 1)->get(); //->toArray();
    return view('products.index', ["products" => $products]);
  }


  public function create()
  {
    return view('products.create');
  }


  // handle to save the new product
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|unique:' . TABLE_PRODUCTS . ',name',
        'description' => 'required|String',
        'price' => 'required|integer|min:1',
        'stockquantity' => 'required|integer|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $product = new Product();

      $name = $request->name;
      $name = str_replace(' ', '', $name);
      $product->name = $name;

      $product->description = $request->description;
      $product->price = $request->price;
      $product->stockquantity = $request->stockquantity;
      $product->save();


      return response()->json(['success' => 'product save succesfully.'], 200);


    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }


  public function edit($id)
  {
    $product = Product::find($id);
    if (!$product) {
      return redirect('products')->with('error', 'product does not exist');
    }

    return view('products.edit', ['product' => $product]);

  }


  // handle to update the existing product
  public function update(Request $request, $id)
  {
    try {

      $id = $request->id;
      $product = Product::find($id);
      if (!$product) {
        return response()->json(['error' => 'product does not exist'], 404);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'description' => 'required|String',
        'price' => 'required|integer',
        'stockquantity' => 'required|integer',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }


      $name = $request->name;
      $name = str_replace(' ', '', $name);
      if (Product::checkProductName($name, $id)) {
        return response()->json([
          'success' => false,
          'errors' => 'The new name already exists..'
        ], 400);
      }

      $product->name = $name;
      $product->description = $request->description;
      $product->price = $request->price;
      $product->stockquantity = $request->stockquantity;

      $product->save();

      return response()->json(['success' => 'product save succesfully.'], 200);

    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }


  public function destroy($id)
  {
    try {
      $id = Product::where('id', $id)->update(['status' => 0]);
      if ($id == 0) {
        return response()->json([
          'errors' => 'product does not exist'
        ], 404);
      }

      return response()->json([
        "success" => "product deleted successfully"
      ], 200);

    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }













  // api level work


  // handle to get all products
  public function getproducts()
  {
    $products = Product::where('status', 1)->get();
    return response()->json([
      "success" => true,
      "message" => 'products fetches successfully',
      'products ' => $products
    ], 200);
  }


  // handle to save the new product
  public function storeProduct(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|unique:' . TABLE_PRODUCTS . ',name',
        'description' => 'required|String',
        'price' => 'required|integer',
        'stockquantity' => 'required|integer',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $product = new Product();

      $name = $request->name;
      $name = str_replace(' ', '', $name);
      $product->name = $name;

      $product->description = $request->description;
      $product->price = $request->price;
      $product->stockquantity = $request->stockquantity;
      $product->save();

      return response()->json(['success' => 'product save succesfully.'], 200);


    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }



  // handle to update the existing product
  public function updateProduct(Request $request, $id)
  {
    try {

      $id = $request->id;
      $product = Product::find($id);
      if (!$product) {
        return response()->json([
          'success' => false,
          'error' => 'product does not exist'
        ], 404);
      }

      if ($request->has('name')) {
        $name = $request->name;
        $name = str_replace(' ', '', $name);

        // Check if the new name already exists in the database
        if (Product::checkProductName($name, $id)) {
          return response()->json([
            'success' => false,
            'error' => 'The new name already exists. Please choose a different name.'
          ], 400);
        }
        $product->name = $name;
      }

      $product->fill($request->except('id', 'name'))->save();
      return response()->json(['success' => 'product updated succesfully.'], 200);

    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }


  // handle to delete the  product
  public function deleteProduct($id)
  {
    try {
      $id = Product::where('id', $id)->update(['status' => 0]);
      if ($id == 0) {
        return response()->json([
          'success' => false,
          'error' => 'product does not exist'
        ], 404);
      }

      return response()->json([
        'success' => true,
        "message" => "product deleted successfully"
      ], 200);

    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }

}