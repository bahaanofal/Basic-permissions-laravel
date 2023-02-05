<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Category::class);
        $categories = Category::all();
        if ($request->ajax()) {
            // $data = Category::all();
            return DataTables::of($categories)->addIndexColumn()
                ->editColumn('created_at', function($category){ 
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $category->created_at)
                                    ->format('d-m-Y h:i:s a'); 
                    return $formatedDate; 
                })
                ->editColumn('parent_id', function($category){ 
                    if($category->parent->name){
                        return $category->parent->name;
                    }else{
                        return 'No Parent';
                    }
                })
                ->addColumn('edit', function($category){
                    $url = url(route('categories.edit', $category->id));
                    $EditButton = '<a href="'.$url.'">Edit</a>';
                    return $EditButton;
                })
                
                ->addColumn('delete', function($category){
                    $url = url(route('categories.destroy', $category->id));
                    $csrf = csrf_token();
                    $DelButton = '<form action="'.$url.'" method="post">
                        <input type="hidden" name="_token" value="'.$csrf.'" />
                        <input type="hidden" name="_method" value="delete">
                        <button class="btn btn-danger btn-sm">del</button>
                        </form>';
                    return $DelButton;
                })
                ->rawColumns(['edit','delete'])
                ->make(true);
        }

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $this->authorize('view-any', Category::class);

    //     $categories = Category::latest()->paginate();
    //     $parents = Category::with('parent')->orderBy('name', 'asc')->get();
    //     return view('admin.categories.index', [
    //         'categories' => $categories,
    //         'parents' => $parents
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Category::class);

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
        $this->authorize('create', Category::class);

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
        $category = Category::findOrFail($id);
        $this->authorize('view', $category);
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
        $this->authorize('update', $category);

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
        $category = Category::findOrFail($id);
        $this->authorize('update', $category);
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
        $this->authorize('delete', $category);

        $category->delete();
        Storage::disk('public')->delete($category->image_path);
        return redirect(route('categories.index'));
    }
}
