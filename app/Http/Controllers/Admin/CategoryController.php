<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['categories'] = Category::latest()->get();
        return view('admin.category.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
            'name' => 'required|string|max:255|unique:categories',
            'image' => 'required|mimes:png,jpg,jpeg'
       ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = imageUpload($image,'category');
        }else{
            $imageName = null;
        }

        $category = new Category();
        $category->name = $request->name;
        $category->image_path = $imageName;
        $category->slug = Str::slug($request->name);
        $category->status = 1;
        $category->save();
        return redirect()->route('admin.category.index')->with('success','Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category_details = Category::find($id);
        return view('admin.category.view',compact('category_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_details = Category::find($id);
        return view('admin.category.edit',compact('category_details'));
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
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'status' => 'required'
       ]);

       $category_details = Category::find($id);

       if($request->hasFile('image')){
        $image = $request->file('image');
        $image_name = explode('/', $category_details->image_path)[2];
        if(File::exists('upload/category/'.$image_name)) {
            File::delete('upload/category/'.$image_name);
        }
        $imageName = imageUpload($image,'category');
        }else{
            $imageName = $category_details->image_path;
        }

        $category_details->name = $request->name;
        $category_details->image_path = $imageName;
        $category_details->slug = Str::slug($request->name);
        $category_details->status = $request->status;
        $category_details->save();
        return redirect()->route('admin.category.index')->with('success','Category details updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
