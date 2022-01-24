@extends('admin.layouts.master')
@section('content')
    <div class="dashboard-body" id="content">
        <div class="dashboard-content">
            <div class="row m-0 dashboard-content-header">
                <div class="col-lg-6 d-flex">
                    <a id="sidebarCollapse" href="javascript:void(0);">
                        <i class="fas fa-bars"></i>
                    </a>
                    <ul class="breadcrumb p-0">
                        <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="{{ route('admin.product.index') }}">All Product List</a></li>
                        <li class="text-white"><i class="fa fa-chevron-right"></i></li>
                        <li><a href="#" class="active">Add Product</a></li>
                    </ul>
                </div>
                @include('admin.layouts.navbar')
            </div>
            <hr>
            <div class="dashboard-body-content">
                <h5>Add Product</h5>
                <hr>
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
                    @csrf
                    <div class="row m-0 pt-3">
                        <div class="col-lg-12">
                            <div class="form-group edit-box">
                                <label for="review">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span style="color: red;">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group edit-box">
                                <label for="review">Category<span class="text-danger">*</span></label>
                                <select name="category" class="form-control" id="category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span style="color: red;">{{ $errors->first('category') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group edit-box">
                                <label for="review">Sub Category<span class="text-danger">*</span></label>
                                <select name="sub_category" class="form-control" id="category">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($sub_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sub_category'))
                                    <span style="color: red;">{{ $errors->first('sub_category') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group edit-box">
                                <label for="review">Image<span class="text-danger">*</span></label>
                                <input type="file" id="image" class="form-control" name="image"
                                    value="{{ old('image') }}">
                                @if ($errors->has('image'))
                                    <span style="color: red;">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row" id="add_multiple_varient">
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">Available Sizes<span class="text-danger">*</span></label>
                                    <select class="form-control"
                                        name="addMoreInputFields[0][sizes]">
                                        <option value="">Select Size</option>
                                        @foreach ($available_product_sizes as $avl_size)
                                            <option value="{{ $avl_size->size }}">{{ $avl_size->size }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger size_err"></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">Colour<span class="text-danger">*</span></label>
                                    <input type="text" id="colors" class="form-control"
                                        name="addMoreInputFields[0][colors]" value="{{ old('colors') }}" min="1">
                                    <span class="text-danger color_err"></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group edit-box">
                                    <label for="review">Price<span class="text-danger">*</span></label>
                                    <input type="number" id="price" class="form-control"
                                        name="addMoreInputFields[0][price]" value="{{ old('price') }}" min="1">
                                    <span class="text-danger price_err"></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" id="add_varient"><i class="fa fa-plus"></i> Add</button>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-group edit-box">
                                <label for="description">Description<span class="text-danger">*</span></label>
                                <textarea name="description"></textarea>
                                @if ($errors->has('description'))
                                    <span style="color: red;">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="actionbutton" id="btn_submit">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.product.product_js')
@endsection
