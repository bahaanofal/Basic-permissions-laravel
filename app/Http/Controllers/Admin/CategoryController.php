<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate();
        $parents = Category::with('parent')->orderBy('name', 'asc')->get();
        return view('admin.categories.index', [
            'categories' => $categories,
            'parents' => $parents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $parents = Category::all();
        return view('admin.categories.create', [
            'category' => $category,
            'parents' => $parents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha|min:3|max:50|unique:categories',
            'image_path' => 'nullable|image',
            'description' => 'nullable|string|min:5',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive'
        ]);
        
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $image_path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image_path'] = $image_path;
        }

        Category::create($data);
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::all()->except($id);
        return view('admin.categories.edit', [
            'category' => $category,
            'parents' => $parents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50|unique:categories,name,'. $id,
            'image_path' => 'nullable|image',
            'description' => 'nullable|string|min:5',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive'
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->all();

        $image_path = null;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $image_path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image_path'] = $image_path;
        }

        $category = Category::findOrFail($id);
        $category->update($data);
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        Storage::disk('public')->delete($category->image_path);
        return redirect(route('categories.index'));
    }
}
