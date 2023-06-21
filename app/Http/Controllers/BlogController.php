<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Create a new blog post.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPost(Request $request)
    {
        if (! $request->user()->isAbleTo('create-posts')) {
            return back(401)->withErrors([
                'error' => 'You are not permitted to create blog posts.',
            ]);
        }

        $request->validate([
            'body'        => 'required|string|max:2500',
            'category_id' => 'sometimes|exists:categories,id',
            'is_private'  => 'sometimes|boolean',
            'title'       => 'required|string|max:255',
        ]);
    }
}
