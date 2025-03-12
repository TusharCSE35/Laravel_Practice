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

    public function ourFileStore(Request $request){
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
        
        flash()->success('Post has been created successfully');
        return redirect()->route('home');

    }

    public function editdata($id){
        $post = DB::select("SELECT * FROM posts WHERE id=?", [$id]);
        
        if(!$post){
            flash()->error('Post not found');
            return redirect()->route('home');
        }

        return view('edit', ['post' => $post[0]]);
    }

    public function updatePost(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $existingPost = DB::select("SELECT * FROM posts WHERE id = ?", [$id]);
        if(!$existingPost){
            flash()->error('Post not found');
            return redirect()->route('home');
        }

        $imagePath = $existingPost[0]->image;
        if($request->hasFile('image')){
            $imagePath = time(). '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imagePath);
        }

        DB::update("UPDATE posts SET name=?, description=?, image=?, updated_at=NOW() WHERE id=?", [
            $request->name,
            $request->description,
            $imagePath,
            $id
        ]);
         
        flash()->success('Post has been updated successfully');
        return redirect()->route('home');
    }

    public function deletePost($id){
        $post = DB::select("SELECT * FROM posts WHERE id=?", [$id]);
        if(!$post){
            flash()->error('Post not found');
            return redirect()->route('home');
        }

        DB::delete("DELETE FROM posts WHERE id=?", [$id]);
        
        flash()->success('Post has been delated successfully');
        return redirect()->route('home');
    }
}

