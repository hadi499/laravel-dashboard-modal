<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $posts = PostResource::collection(Post::latest()->get());
        // $image_url = asset('storage/');
        return Inertia::render('Dashboard/Index', [
            'posts' => $posts,
            'categories' => $categories,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Dashboard/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            // 'slug' => 'required|unique:posts',
            'image' => 'image|file|max:1024|nullable',
            'category_id' => 'required',
            'body' => 'required'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 30);
        Post::create($validatedData);

        return redirect(route('dashboard.index'));
    }

    public function update(Request $request, Post $post)
    {

        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024|nullable',
            'body' => 'required'
        ];

        if ($request->slug != $post->slug) {
            $rules['slug'] =  'required|unique:posts';
        }
        $validatedData = $request->validate($rules);
        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        } else {

            $validatedData['image'] = $request->oldImage;
        }
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 30);

        $post->update($validatedData);

        return redirect("/dashboard");
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

        if ($post->image) {
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('/dashboard')->with('success', 'post has been deleted!');
    }
}
