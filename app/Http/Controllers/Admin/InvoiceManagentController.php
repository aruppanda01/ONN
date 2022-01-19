<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InvoiceManagentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['all_invoice_list'] = Invoice::latest()->get();
        return view('admin.invoice.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.invoice.create');
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
            'invoice_date' => 'required|date',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
            'location' => 'required|max:255',
            'amount' => 'required'
        ]);

        $new_invoice_details = new Invoice();

        // Image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $new_invoice_details->image_path = imageUpload($image,'invoice/images');
        }else{
            $new_invoice_details->image_path = null;
        }

        // Other Details
        $new_invoice_details->invoice_date = $request->invoice_date;
        $new_invoice_details->lat = $request->latitude;
        $new_invoice_details->lon = $request->longitude;
        $new_invoice_details->location = $request->location;
        $new_invoice_details->amount = $request->amount;
        $new_invoice_details->is_verified = 1;
        $new_invoice_details->save();

        return redirect()->route('admin.invoice.index')->with('success','Invoice details added');
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
        $data['invoice_details'] = Invoice::find($id);
        return view('admin.invoice.view')->with($data);
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
        $data['invoice_details'] = Invoice::find($id);
        return view('admin.invoice.edit')->with($data);
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
            'invoice_date' => 'required|date',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
            'location' => 'required|max:255',
            'amount' => 'required'
        ]);

        $update_invoice_details = Invoice::find($id);

        // Image

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = explode('/', $update_invoice_details->image_path)[2];
            if(File::exists('upload/invoice/images/'.$image_name)) {
                File::delete('upload/invoice/images/'.$image_name);
            }
            $update_invoice_details->image_path = imageUpload($image,'invoice/images');
        }else{
            $update_invoice_details->image_path = $update_invoice_details->image_path;
        }

        // Other Details
        $update_invoice_details->invoice_date = $request->invoice_date;
        $update_invoice_details->lat = $request->latitude;
        $update_invoice_details->lon = $request->longitude;
        $update_invoice_details->location = $request->location;
        $update_invoice_details->amount = $request->amount;
        $update_invoice_details->is_verified = 1;
        $update_invoice_details->save();

        return redirect()->route('admin.invoice.index')->with('success','Invoice details updated');
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
