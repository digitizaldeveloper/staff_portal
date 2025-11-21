<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    // Show table
public function index()
{
    $categories = BlogCategory::orderBy('id', 'DESC')->paginate(5);
    return view('admin.blog_categories.index', compact('categories'));
}


    // Show create form
    public function create()
    {
        return view('admin.blog_categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:blog_categories,title',
            'description' => 'nullable'
        ]);

        BlogCategory::create($request->only('title', 'description'));

        return redirect()->route('admin.blog_categories.index')
                         ->with('success', 'Category created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog_categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
            'title' => 'required|unique:blog_categories,title,' . $id,
            'description' => 'nullable'
        ]);

        $category->update($request->only('title', 'description'));

        return redirect()->route('admin.blog_categories.index')
                         ->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function destroy($id)
    {
        BlogCategory::findOrFail($id)->delete();

        return redirect()->route('admin.blog_categories.index')
                         ->with('success', 'Category deleted successfully!');
    }
}
