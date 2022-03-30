@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                    <h5 class="modal-title">Edit Product</h5>
                </div>
                <div class="card-toolbar">
                    <a href="{{route('index')}}" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form id="form_edit_product">
                    <div class="form-group">
                        <label for="edit_main_category" class="col-form-label fs-6 text-secondary">Main Category
                            <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_main_category" name="edit_main_category">
                            <option value="{{$product_main_category->id}}">{{$product_main_category->name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_sub_one_category" class="col-form-label fs-6 text-secondary">Sub-One Category
                            <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_sub_one_category" name="edit_sub_one_category">
                            <option value="{{$product_sub_one_category->id}}">{{$product_sub_one_category->name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_sub_two_category" class="col-form-label fs-6 text-secondary">Sub-Two Category
                            <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_sub_two_category" name="edit_sub_two_category">
                            <option value="{{$product_sub_two_category->id}}">{{$product_sub_two_category->name}}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <label for="edit_product_name" class="col-form-label fs-6 text-secondary">Product Name
                                <span class="text-danger">*</span></label>
                            <input value="{{$product->name}}" class="form-control required" placeholder="Enter product name..." type="text" name="edit_product_name" id="edit_product_name"/>
                        </div>
                        <div class="col-4">
                            <label for="edit_product_price" class="col-form-label fs-6 text-secondary">Price
                                <span class="text-danger">*</span></label>
                            <input value="{{$product->price}}" class="form-control required" placeholder="Enter price..." type="text" name="edit_product_price" id="edit_product_price"/>
                        </div>
                        <div class="col-4">
                            <label for="edit_product_quantity" class="col-form-label fs-6 text-secondary">Quantity
                                <span class="text-danger">*</span></label>
                            <input value="{{$product->quantity_in_stock}}" class="form-control required" placeholder="Enter quantity..." type="text" name="edit_product_quantity" id="edit_product_quantity"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_description" class="col-form-label fs-6 text-secondary">Description</label>
                        <textarea class="form-control" name="edit_product_description" id="edit_product_description" cols="30" rows="3" placeholder="Enter description...">{{$product->description}}</textarea>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-success btn-md px-5" id="btn_product_update" data-value="{{$product->id}}">
                    Save
                </button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{"/js/product.js"}}"></script>
@endsection
