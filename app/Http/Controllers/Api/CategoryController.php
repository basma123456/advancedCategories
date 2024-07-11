<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryOnlyResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /*
     * * get all category with its parent category and its children categories
     * the pagination variable is in the env file
     */
    public function index()
    {
        $cats = Category::with('parent', 'children')->paginate(config('app.pagination_num'));
        if ($cats->count() < 1) {
            return $this->error($message = 'no data found', [], $code = 404);
        }
        return $this->paginate(CategoryResource::collection($cats) );

    }



    /*
     * check if Category is found or no  after that
     *     show unique products   from   category and sub categories and parent category
     *    and also show these categories
     */

    public function show($id)
    {
        try {
            $category = Category::with('children', 'parent')->findOrFail($id);
        } catch (\Exception $e) {
            return $this->error($message = 'no category found', [], $code = 404);
        }


        $myCategory = new CategoryOnlyResource($category);

        /*******start get unique products   from   category and sub categories and parent category ************/
        $products = $category->load('children.products', 'parent.products', 'products')->products->merge(
            $category->children->flatMap(function ($child) {
                return $child->products;
            })
        )->merge(
            $category->parent ? $category->parent->products : collect()
        )->unique('id');
        /*******end get unique products   from   category and sub categories and parent category ************/


        $data = ['products' => ProductResource::collection($products), 'category' => $myCategory];


        if ($products->count() < 1) {
            return $this->success($myCategory, 'no products found in this category', true, 200);
        }
        return $this->success($data, '', true, 200);

    }





    public function store(CategoryRequest $request)
    {
        $cat = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return $this->success(new CategoryResource($cat), 'you created new category successfully', true, 201);

    }





    public function update(CategoryRequest $request, $id)
    {
        try {
            $cat = Category::findOrFail($id);
        } catch (\Exception $e) {
            return $this->error($message = 'no category found', [], $code = 404);
        }

        $cat->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return $this->success(new CategoryResource($cat), 'category has been updated successfully', true, 201);


    }




    /*
     * first check if the category is found or no
     * then check
     * if the category has childern or no if no so you can not delete
     *  until delete those children first
     * *
     * then check
     * if the category has products or no if no so you can not delete
     *  until delete those products first

     */
    public function destroy($id)
    {
        try {
            $cat = Category::findOrFail($id);
        } catch (\Exception $e) {
            return $this->error($message = 'no category found', [], $code = 404);
        }

        if ($cat->children && $cat->children()->count() > 0) {
            return $this->error($message = 'you can not delete this category because it has sub categories , so please delete the sub categories first', [], $code = 403);
        }

        if ($cat->products && $cat->products()->count() > 0) {
            return $this->error($message = 'you can not delete this category because it has products   , so please delete the products first', [], $code = 403);
        }

        $cat->delete();

        return $this->success([], 'category has been deleted successfully', true, 201);


    }


}
