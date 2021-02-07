<?php

namespace App\Http\Controllers;

use App\Http\Resources;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostController extends Controller
{
    public function index(): ResourceCollection
    {
        return Resources\Post::collection(Post::where('user_id', auth()->id())->get());
    }

    public function store(Request $request): Resources\Post
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $post = Post::create($data);
        $post->categories()->sync($data['categories']);
        return new Resources\Post($post);
    }

    public function show($id): Resources\Post
    {
        return new Resources\Post(Post::find($id));
    }

    public function update(Request $request, $id): Resources\Post
    {
        $post = Post::find($id);
        $post->update($request->all());
        $post->categories()->sync($request['categories']);
        return new Resources\Post($post);
    }

    public function destroy($id): JsonResponse
    {
        return response()->json(Post::find($id)->delete());
    }

    public function uploadImage(Request $request): JsonResponse
    {
        if (!$request->hasFile('file')) {
            return response()->json(['Uploadable file is not found'], 400);
        }
        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['File is not valid'], 400);
        }

        $path = '/posts/images/' . auth()->id();
        $file->move(public_path() . $path, $file->getClientOriginalName());

        return response()->json('http://127.0.0.1' . $path . '/' . $file->getClientOriginalName());
    }
}
