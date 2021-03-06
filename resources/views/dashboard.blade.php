@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{"/css/upload-product-image.css"}}">
@endsection

@section('content')
    @include('layouts.partials.navbar')
    <div class="container">
        <div class="card card-custom card-shadow mt-5">
            <div class="card-header bg-warning">
                <div class="card-title">
                    <h5 class="text-white">Products</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row" id="product_area">
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                            <div class="card">
                                <img
                                    src="@if($product->path !== null) {{ asset('product-images/'.$product->path) }} @else {{ asset('/product-images/default.jpg') }} @endif"
                                    class="p-2"
                                    style="width:100%;height:200px;object-fit: cover;"/>
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-center"><span class="text-success fw-bolder">{{$product->price}} TL</span></div>
                                    <div class="card-title fw-bolder text-truncate">
                                        {{$product->name}}
                                    </div>
                                    <p class="card-text text-truncate">
                                        {{$product->description}}
                                    </p>
                                </div>
                                <div class="card-footer d-flex flex-column">
                                    <div class="d-flex justify-content-between mb-3">
                                        <button class="btn btn-primary" id="btn_add_product_to_basket"
                                                data-value="{{$product->id}}">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width:150px;">
                                            <button class="btn btn-sm btn-outline-secondary bootstrap-touchspin-down rounded-0 btn-decrease"
                                                    type="button">-
                                            </button>
                                            <input type="text" name="product_count" class="form-control text-center border border-dark product_quantity" value="0"/>
                                            <button class="btn btn-sm btn-outline-secondary bootstrap-touchspin-up rounded-0 btn-increase"
                                                    type="button">+
                                            </button>
                                        </div>
                                    </div>
                                  <div class="d-flex justify-content-end">
                                      <a href="{{route("product.edit",$product->id)}}" role="button"
                                         class="btn btn-warning me-3" id="btn_product_edit">
                                          <i class="fa-solid fa-pen-to-square"></i>
                                      </a>
                                      <a href="{{route("product.delete",$product->id)}}" class="btn btn-danger"
                                         id="btn_product_delete">
                                          <i class="fa-solid fa-trash-can"></i>
                                      </a>
                                  </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Create Category Modal -->
    <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="" id="form_category">
                            <div class="form-group">
                                <label for="category_type" class="col-form-label fs-6 text-secondary">Category
                                    <span class="text-danger">*</span></label></label>
                                <select class="form-control" id="category_type" name="category_type">
                                    <option value="" disabled hidden selected></option>
                                    @foreach($category_types as $category_type)
                                        <option value="{{$category_type->code}}">{{$category_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="main_category_area">
                                <label for="main_category" class="col-form-label fs-6 text-secondary">Main Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="main_category" name="main_category">
                                    <option value="" disabled hidden selected></option>
                                </select>
                            </div>
                            <div class="form-group" id="sub_one_category_area">
                                <label for="sub_one_category" class="col-form-label fs-6 text-secondary">Sub-One
                                    Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="sub_one_category" name="sub_one_category">
                                    <option value="" disabled hidden selected></option>
                                </select>
                            </div>
                            <div class="form-group" id="sub_two_category_area">
                                <label for="sub_two_category" class="col-form-label fs-6 text-secondary">Sub-Two
                                    Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="sub_two_category" name="sub_two_category">
                                    <option value="" disabled hidden selected></option>
                                </select>
                            </div>
                            <div class="form-group" id="category_name_area">
                                <label for="category_name" class="col-form-label fs-6 text-secondary">Category Name
                                    <span class="text-danger">*</span></label>
                                <input class="form-control required" placeholder="Enter category name..." type="text"
                                       name="category_name" id="category_name"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_category">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Product Modal -->
    <div class="modal fade" id="addProductModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Product</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="form_product">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <div class="button_outer">
                                        <div class="btn_upload">
                                            <label for="product_image" class="col-form-label"></label>
                                            <input type="file" name="product_image" id="product_image"
                                                   accept=".png, .jpg, .jpeg,.doc,.docx,.xls,.xlsx,.pdf"/><i
                                                class="fas fa-cloud-upload-alt icon-custom-color icon-md me-3"></i><span
                                                class="fs-lg">Dosya Ekle</span>
                                        </div>
                                        <div class="processing_bar"></div>
                                        <div class="success_box"></div>
                                    </div>
                                    <div class="error_msg text-center"></div>
                                    <div class="uploaded_file_view" id="uploaded_view">
                                        <span class="file_remove">X</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="add_product_main_category" class="col-form-label fs-6 text-secondary">Main
                                    Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="add_product_main_category"
                                        name="add_product_main_category">
                                    <option value="" disabled hidden selected></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_product_sub_one_category" class="col-form-label fs-6 text-secondary">Sub-One
                                    Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="add_product_sub_one_category"
                                        name="add_product_sub_one_category">
                                    <option value="" disabled hidden selected></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_product_sub_two_category" class="col-form-label fs-6 text-secondary">Sub-Two
                                    Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="add_product_sub_two_category"
                                        name="add_product_sub_two_category">
                                    <option value="" disabled hidden selected></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_name" class="col-form-label fs-6 text-secondary">Product Name
                                    <span class="text-danger">*</span></label>
                                <input class="form-control required" placeholder="Enter product name..." type="text"
                                       name="product_name" id="product_name"/>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="product_price" class="col-form-label fs-6 text-secondary">Price
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control required" placeholder="Enter price..." type="text"
                                           name="product_price" id="product_price"/>
                                </div>
                                <div class="col-6">
                                    <label for="product_quantity" class="col-form-label fs-6 text-secondary">Quantity
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control required" placeholder="Enter quantity..." type="text"
                                           name="product_quantity" id="product_quantity"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_description"
                                       class="col-form-label fs-6 text-secondary">Description</label>
                                <textarea class="form-control" name="product_description" id="product_description"
                                          cols="30" rows="3" placeholder="Enter description..."></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_product">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{"/js/category.js"}}"></script>
    <script src="{{"/js/product.js"}}"></script>
    <script src="{{"/js/upload-image.js"}}"></script>
@endsection
