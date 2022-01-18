<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['products'] = Product::latest()->get();
        return view('admin.product.index')->with($data);
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
        $data['sub_categories'] = SubCategory::where('status',1)->latest()->get();
        return view('admin.product.create')->with($data);
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
            'name' => 'required|string|max:255|unique:products',
            'category' => 'required',
            'sub_category' => 'required',
            'available_sizes' => 'nullable',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'description' => 'required|max:700'
        ]);

        $new_product = new Product();

        // Product Code
        $product_count = Product::count();
        $num_padded = sprintf("%06d", ($product_count + 1));
        $new_product->product_code = 'ONN' . $num_padded;

        // Available Sizes
        $available_sizes = $request->available_sizes;
        if ($available_sizes) {
            $new_product->available_sizes = implode(',', $available_sizes);
        }

        // Image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $new_product->image_path = imageUpload($image,'products');
        }else{
            $new_product->image_path = null;
        }

        // Other Details

        $new_product->name = $request->name;
        $new_product->slug = Str::slug($request->name);
        $new_product->category_id = $request->category;
        $new_product->sub_category_id = $request->sub_category;
        $new_product->price = $request->price;
        $new_product->description = $request->description;
        $new_product->status = 1;
        $new_product->save();

        return redirect()->route('admin.product.index')->with('success','Product added');
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
        $data = array();
        $data['product_details'] = Product::find($id);
        $data['categories'] = Category::where('status',1)->latest()->get();
        $data['sub_categories'] = SubCategory::where('status',1)->latest()->get();
        return view('admin.product.edit')->with($data);
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
            'category' => 'required',
            'sub_category' => 'required',
            'available_sizes' => 'nullable',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'description' => 'required|max:700'
        ]);

        $new_product = Product::find($id);

        // Available Sizes
        $available_sizes = $request->available_sizes;
        if ($available_sizes) {
            $new_product->available_sizes = implode(',', $available_sizes);
        }

        // Image

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = explode('/', $new_product->image_path)[2];
            if(File::exists('upload/products/'.$image_name)) {
                File::delete('upload/products/'.$image_name);
            }
            $new_product->image_path = imageUpload($image,'products');
        }else{
            $new_product->image_path = $new_product->image_path;
        }

        // Other Details

        $new_product->name = $request->name;
        $new_product->slug = Str::slug($request->name);
        $new_product->category_id = $request->category;
        $new_product->sub_category_id = $request->sub_category;
        $new_product->price = $request->price;
        $new_product->description = $request->description;
        $new_product->status = $request->status;
        $new_product->save();

        return redirect()->route('admin.product.index')->with('success','Product details updated');
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
