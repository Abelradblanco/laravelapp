<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function deletePost(Post $post){
        if (auth()->user()->id === $post['user_id']){
            $post->delete();
        }
        return redirect('/');
    }

    public function updatePost(Post $post, Request $request){
        if (auth()->user()->id !== $post['user_id']){
            return redirect('/')->with('You cannot update other authors posts');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        //actually update the info
        $post->update($incomingFields);
        return redirect('/');
    }

    //$post has to match the same '/edit-post/{post}' inside web.php
    public function showEditScreen(Post $post){

        if (auth()->user()->id !== $post['user_id']){
            return redirect('/')->with('message', 'You do not have access to this page');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body'  => ['required','min:2']
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        //match user id so that it has tghe same autherid
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);

        return redirect('/');

    }
}
