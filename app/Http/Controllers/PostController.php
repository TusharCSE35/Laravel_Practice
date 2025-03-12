<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //create function
    public function create(){
        return view('create'); 
    } 

    public function ourfilestore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if(isset($request->image)){
            $imagePath = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imagePath);
        }
        
        DB::insert("INSERT INTO posts (name, description, image, created_at, updated_at) VALUES(?, ?, ?, NOW(), NOW())",[
            $request->name,
            $request->description,
            $imagePath ?? null
        ]);

        return redirect()->route('home')->with('success', 'Post hass been created');
    }

    public function editdata($id){
        $post = DB::select("SELECT * FROM posts WHERE id=?", [$id]);
        
        if(!$post){
            return redirect()->route('home')->with('error', 'Post not found');
        }

        return view('edit', ['post' => $post[0]]);
    }


    public function updatePost(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Retrieve the existing post
        $existingPost = DB::select("SELECT * FROM posts WHERE id = ?", [$id]);

        if (!$existingPost) {
            return redirect()->route('home')->with('error', 'Post not found');
        }

        $imagePath = $existingPost[0]->image; // Keep old image if no new image is uploaded

        if ($request->hasFile('image')) {
            $imagePath = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imagePath);
        }

        // Update the post
        DB::update("UPDATE posts SET name = ?, description = ?, image = ?, updated_at = NOW() WHERE id = ?", [
            $request->name,
            $request->description,
            $imagePath,
            $id
        ]);

        return redirect()->route('home')->with('success', 'Post has been updated successfully');
    }
}

