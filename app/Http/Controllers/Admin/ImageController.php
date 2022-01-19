<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['images'] = Image::latest()->get();
        return view('admin.image.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.image.create');
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
            'image' => 'required|mimes:png,jpg,jpeg',
            'capture_date' => 'required|date',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
            'location' => 'required|max:255',
        ]);

        $new_image_details = new Image();

        // Image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $new_image_details->image_path = imageUpload($image,'images');
        }else{
            $new_image_details->image_path = null;
        }

        // Other Details
        $new_image_details->image_capture_date = $request->capture_date;
        $new_image_details->lat = $request->latitude;
        $new_image_details->lon = $request->longitude;
        $new_image_details->location = $request->location;
        $new_image_details->status = 1;
        $new_image_details->save();

        return redirect()->route('admin.image.index')->with('success','Image details added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['image_details'] = Image::find($id);
        return view('admin.image.view')->with($data);
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
        $data['image_details'] = Image::find($id);
        return view('admin.image.edit')->with($data);
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
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'capture_date' => 'required|date',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
            'location' => 'required|max:255',
        ]);

        $update_image_details = Image::find($id);

        // Image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = explode('/', $update_image_details->image_path)[2];
            if(File::exists('upload/products/'.$image_name)) {
                File::delete('upload/products/'.$image_name);
            }
            $update_image_details->image_path = imageUpload($image,'products');
        }else{
            $update_image_details->image_path = $update_image_details->image_path;
        }

        // Other Details
        $update_image_details->image_capture_date = $request->capture_date;
        $update_image_details->lat = $request->latitude;
        $update_image_details->lon = $request->longitude;
        $update_image_details->location = $request->location;
        $update_image_details->status = $request->status;
        $update_image_details->save();

        return redirect()->route('admin.image.index')->with('success','Image details updated');
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
