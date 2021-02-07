<?php

namespace App\Http\Controllers;

use App\Http\Resources;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    public function index(): ResourceCollection
    {
        return Resources\Category::collection(Category::all());
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());
        return $category;
    }

    public function destroy($id): JsonResponse
    {
        return response()->json(Category::find($id)->delete());
    }
}
