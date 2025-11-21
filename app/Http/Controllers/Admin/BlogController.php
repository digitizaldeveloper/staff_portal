<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        // $blogs = Blog::with('category')->latest()->get();
        $blogs = Blog::orderBy('id', 'DESC')->paginate(5);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15048'
        ]);
         $imageName = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
    }


        Blog::create([
            'title' => $request->title,
            'slug'  => Str::slug($request->title),
            'short_description' => $request->short_description,
            'content' => $request->content,
            'image' => $imageName,
            'status' => $request->status,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $imageName = $blog->image;

    if ($request->hasFile('image')) {

        // delete old image
        if ($blog->image && file_exists(public_path('images/'.$blog->image))) {
            unlink(public_path('images/'.$blog->image));
        }

        // upload new image
        $image = $request->file('image');
        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
    }

        $blog->update([
            'title' => $request->title,
            'slug'  => Str::slug($request->title),
            'short_description' => $request->short_description,
            'content' => $request->content,
            'image' => $imageName,
            'status' => $request->status,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated!');
    }

    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted!');
    }
}
