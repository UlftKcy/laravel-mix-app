@extends('layouts.app')

@section('content')

    <!-- Create Category Modal -->
    <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
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
                                <label for="sub_one_category" class="col-form-label fs-6 text-secondary">Sub-One Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="sub_one_category" name="sub_one_category">
                                    <option value="" disabled hidden selected></option>
                                    {{-- @foreach($category_types as $category_type)
                                         <option value="{{$category_type->id}}">{{$category_type->name}}</option>
                                     @endforeach--}}
                                </select>
                            </div>
                            <div class="form-group" id="sub_two_category_area">
                                <label for="sub_two_category" class="col-form-label fs-6 text-secondary">Sub-Two Category
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="sub_two_category" name="sub_two_category">
                                    <option value="" disabled hidden selected></option>
                                    {{-- @foreach($category_types as $category_type)
                                         <option value="{{$category_type->id}}">{{$category_type->name}}</option>
                                     @endforeach--}}
                                </select>
                            </div>
                            <div class="form-group" id="category_name_area">
                                <label for="category_name" class="col-form-label fs-6 text-secondary">Category Name
                                    <span class="text-danger">*</span></label>
                                <input class="form-control required" placeholder="Enter category name..." type="text" name="category_name" id="category_name"/>
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
@endsection
@section('scripts')
    <script src="{{"/js/category.js"}}"></script>
@endsection
