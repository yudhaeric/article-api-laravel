<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index() {
        $article = Post::all();
        // return response()->json(['data' => $article]);

        return PostResource::collection($article);
    }
}
