<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['categories'] = SubCategory::latest()->get();
        return view('admin.sub_category.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['categories'] = Category::where('status',1)->latest()->get();
        return view('admin.sub_category.create')->with($data);
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
            'name' => 'required|string|max:255|unique:sub_categories',
            'image' => 'required|mimes:png,jpg,jpeg',
            'category' => 'required'
       ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = imageUpload($image,'sub_categories');
        }else{
            $imageName = null;
        }

        $category = new SubCategory();
        $category->name = $request->name;
        $category->image_path = $imageName;
        $category->slug = Str::slug($request->name);
        $category->category_id = $request->category;
        $category->status = 1;
        $category->save();
        return redirect()->route('admin.sub-category.index')->with('success','Sub Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category_details = SubCategory::find($id);
        return view('admin.sub_category.view',compact('category_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['category_list'] = Category::where('status',1)->latest()->get();
        $data['category_details'] = SubCategory::find($id);
        return view('admin.sub_category.edit')->with($data);
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
            'category' => 'required',
            'status' => 'required'
       ]);

       $category_details = SubCategory::find($id);

       if($request->hasFile('image')){
        $image = $request->file('image');
        $image_name = explode('/', $category_details->image_path)[2];
        if(File::exists('upload/sub_categories/'.$image_name)) {
            File::delete('upload/sub_categories/'.$image_name);
        }
        $imageName = imageUpload($image,'sub_categories');
        }else{
            $imageName = $category_details->image_path;
        }

        $category_details->category_id = $request->category;
        $category_details->name = $request->name;
        $category_details->image_path = $imageName;
        $category_details->slug = Str::slug($request->name);
        $category_details->status = $request->status;
        $category_details->save();
        return redirect()->route('admin.sub-category.index')->with('success','Sub Category details updated');
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
