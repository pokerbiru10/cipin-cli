<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display blog listing
     */
    public function index()
    {
        $posts = Post::published()
            ->orderBy('published_at', 'desc')
            ->get();

        return view('blog', compact('posts'));
    }

    /**
     * Display single blog post
     */
    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('detail-news', compact('post'));
    }
}
