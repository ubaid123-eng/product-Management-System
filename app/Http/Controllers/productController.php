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
      $validator = $this->validateRequest($request);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $this->createProduct($request);

      return response()->json(['success' => 'Product saved successfully.'], 200);
    } catch (\Exception $e) {
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
      $product = $this->findProduct($id);

      if (!$product) {
        return response()->json(['error' => 'Product does not exist'], 404);
      }

      $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'description' => 'required|String',
        'price' => 'required|integer|min:1',
        'stockquantity' => 'required|integer|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $name = $this->sanitizeName($request->name);

      if ($this->checkProductName($name, $id)) {
        return response()->json([
          'success' => false,
          'errors' => 'The new name already exists.'
        ], 400);
      }

      $this->updateProducts($product, $request);
      return response()->json(['success' => 'Product updated successfully.'], 200);

    } catch (\Exception $e) {
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }


  // handle to soft delete the product
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









  // private functions


  private function validateRequest(Request $request)
  {
    return Validator::make($request->all(), [
      'name' => 'required|string|unique:' . TABLE_PRODUCTS . ',name',
      'description' => 'required|string',
      'price' => 'required|integer|min:1',
      'stockquantity' => 'required|integer|min:1',
    ]);
  }



  private function createProduct(Request $request)
  {
    $product = new Product();

    $product->name = $this->sanitizeName($request->name);
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stockquantity = $request->stockquantity;
    $product->save();

    return $product;
  }

  // handle to remove spaces between product name so we can make it unique
  private function sanitizeName($name)
  {
    return str_replace(' ', '', $name);
  }



  private function findProduct($id)
  {
    return Product::find($id);
  }

  // handle to check the product name while updating either it is already existing or not
  private function checkProductName($name, $id)
  {
    return Product::checkProductName($name, $id);
  }

  private function updateProducts($product, Request $request)
  {
    $product->name = $this->sanitizeName($request->name);
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stockquantity = $request->stockquantity;

    $product->save();

    return $product;
  }




  private function validateupdateRequest(Request $request)
  {
    $errors = [];

    if ($request->price <= 0 || $request->stockquantity <= 0) {
      $errors[] = 'Price and stock quantity must be greater than 0.';
    }

    if (!empty($errors)) {
      return [
        'success' => false,
        'errors' => $errors,
        'status' => 400
      ];
    }

    return ['success' => true];
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
      return productController::store($request);
    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }



  // handle to update the existing product
  public function updateProduct(Request $request, $id)
  {
    try {

      $product = $this->findProduct($id);
      if (!$product) {
        return response()->json([
          'success' => false,
          'error' => 'product does not exist'
        ], 404);
      }

      if ($request->has('name')) {
        $name = $this->sanitizeName($request->name);
        if ($this->checkProductName($name, $id)) {
          return response()->json([
            'success' => false,
            'errors' => 'The new name already exists.'
          ], 400);
        }
        $product->name = $name;
      }

      $validationResult = $this->validateupdateRequest($request);
      if (!$validationResult['success']) {
        return response()->json($validationResult, $validationResult['status']);
      }

      $product->fill($request->except('id', 'name'))->save();
      return response()->json(['success' => 'product updated succesfully.'], 200);

    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }




  // handle to soft delete the product
  public function deleteProduct(Request $request, $id)
  {
    try {
      $id = $request->id;
      return productController::destroy($id);

    } catch (\Exception $e) {
      echo $e->getMessage();
      return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    }
  }

}