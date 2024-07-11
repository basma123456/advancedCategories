<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    /*######################################################################
        here you can search by  name of category or sub category  or any category has relation with that product
        or by name of product or by description of product  or by price of product or
        if you want make no parameter for search it will get all products list
        so it is optional to make filter or no
      ###################################################################### */
    public function search(Request $request)
    {
        $term = $request->filter;
        $filters = Product::with('categories:id,name')->Search($term)
            ->paginate(config('app.pagination_num'))
            ->setPath('')
            ->appends(array(
                'filter' => $request->filter
            ));

        if ($filters->count() < 1) {
            return $this->error($message = 'no products found', [], $code = 404);
        }
        return $this->success(ProductResource::collection($filters), '', true, 200);
    }


    public function show($id)
    {
        try {
            $product = Product::with('categories:id,name')->findOrFail($id);
            return $this->success(new ProductResource($product), '', true, 200);
        } catch (\Exception $e) {
            return $this->error($message = 'no data found', [], $code = 404);
        }

    }


    /*
    here you can add new product and attach this product to a category
    or multiple categories (array of categories = $request->category_id) as you want
   */
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        $product->categories()->attach($request->category_id);

        return $this->success(new ProductResource($product), 'product has been created successfully', true, 201);
    }


    /*
here you can update product and sync this product to a category
or multiple categories as this function is making detaching first then making attaching for $request->category_id array
*/
    public function update(ProductRequest $request, $id)
    {

        try {
            $product = Product::findOrFail($id);
        } catch (\Exception $e) {
            return $this->error($message = 'no product found', [], $code = 404);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        $product->categories()->sync($request->category_id);

        return $this->success(new ProductResource($product), 'product has been updated successfully', true, 201);

    }


    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return $this->success([], 'product has been deleted successfully', true, 201);
        } catch (\Exception $e) {
            return $this->error($message = 'no product found', [], $code = 404);
        }

    }


}
