<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:4096',
        ]);


        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::id();


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            if ($image->isValid()) {
                if ($image->getSize() > 4194304) {  // 4MB
                    // DOESNT WORK :D
                    return back()->withErrors(['image' => 'Image is too large. Maximum size is 4MB.']);
                }
                $incomingFields['path'] = $image->store('uploads', 'public');
                
                UploadedFile::create([
                    'original_name' => $image->getClientOriginalName(),
                    'path' => $incomingFields['path'],
                    'mime_type' => $image->getClientMimeType(),
                    'size' => $image->getSize(),
                ]);
            }
        }

        Post::create($incomingFields);
        return redirect('/');
    }


    
    public function deletePost(Post $post){
        
        if (Auth::user()->id === $post['user_id'] || Auth::user()->isAdmin()){
            if ($post->path) {
                Storage::disk('public')->delete($post->path);
            }
            $post->delete();
        }
        return redirect('/');
    }

    public function updatePost(Post $post, Request $request){
        if (Auth::user()->id !== $post['user_id']){
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body'  => 'required',
            'image' => 'nullable|image|max:4096',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            if ($image->isValid()) {
                if ($image->getSize() > 4194304) {  // 4MB
                    // DOESNT WORK :D
                    return back()->withErrors(['image' => 'Image is too large. Maximum size is 4MB.']);
                }
                $incomingFields['path'] = $image->store('uploads', 'public');
                
                UploadedFile::create([
                    'original_name' => $image->getClientOriginalName(),
                    'path' => $incomingFields['path'],
                    'mime_type' => $image->getClientMimeType(),
                    'size' => $image->getSize(),
                ]);
            }
        }

        $post->update($incomingFields);
        session()->flash('message', 'Post successfully updated.');

        return redirect('/');
    }

    public function showEditScreen(Post $post){
        if (Auth::user()->id !== $post['user_id']){
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function showEditScreenComments(Comment $comment){
        if (Auth::user()->id !== $comment['user_id']){
            return redirect('/');
        }

        return view('edit-comment', ['comment' => $comment]);
    }



    public function addComment(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
            'body' => $request->body,
            'created_at' => now(),
        ]);

        return back()->with('message', 'Comment added!');
    }

    public function updateComment(Comment $comment, Request $request)
    {
        if (Auth::user()->id !== $comment['user_id']){
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $comment->update($incomingFields);
        session()->flash('message', 'Comment successfully updated.');
        return redirect('/');
    }

    public function deleteComment(Comment $comment){
        
        if (Auth::user()->id === $comment['user_id'] || Auth::user()->isAdmin()){
            $comment->delete();
        }
        session()->flash('message', 'Comment successfully deleted.');

        return redirect('/');
    }


}
