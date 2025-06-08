<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class PostApiController extends Controller
{
    public function getAllPosts(Request $request)
    {
        $query = Post::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('body')) {
            $query->where('body', 'like', '%' . $request->body . '%');
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('created_at', $request->sort);
        }

        if ($request->has('has_image')) {
            if ($request->has_image === 'true') {
                $query->whereNotNull('path');
            } elseif ($request->has_image === 'false') {
                $query->whereNull('path');
            }
        }

        $posts = $query->get();

        return response()->json($posts);
    }
}
