<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostDetailResource;

class ArticleController extends Controller
{
    public function index() {
        $article = Post::all();
        // use with
        // $article = Post::with('author:id,username')->get();

        // use loadMissing
        return PostDetailResource::collection($article->loadMissing('author:id,username'));
    }

    public function detail($id) {
        $article = Post::with('author:id,username')->findOrFail($id);
        return new PostDetailResource($article);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'article' => 'required',
        ]);

        $request['author_id'] = Auth::user()->id;
        $article = Post::create($request->all());

        return new PostDetailResource($article->loadMissing('author:id,username'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'article' => 'required',
        ]);

        $article = Post::findOrFail($id);
        $article->update($request->all());

        return new PostDetailResource($article->loadMissing('author:id,username'));
    }
}
