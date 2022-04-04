@extends('layouts.app')

@section('style')

@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-warning bg-gradient">
                <div class="card-title">
                    <h5 class="modal-title text-secondary">My Basket</h5>
                </div>
                <div class="card-toolbar">
                    <a href="{{route('index')}}" class="btn btn-secondary bg-gradient">Back</a>
                </div>
            </div>
            <div class="card-body p-5 bg-light bg-gradient">
                @foreach($basket_products as $basket_product)
                    <div class="row mb-5">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-6">
                                    {{$basket_product->name}}
                                </div>
                                <div class="col-3">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width:150px;">
                                        <button class="btn btn-sm btn-outline-secondary bootstrap-touchspin-down rounded-0 btn-decrease"
                                                type="button">-
                                        </button>
                                        <input type="text" name="product_count" class="form-control text-center border border-dark product_quantity" value="{{$basket_product->quantity}}"/>
                                        <button class="btn btn-sm btn-outline-secondary bootstrap-touchspin-up rounded-0 btn-increase"
                                                type="button">+
                                        </button>
                                    </div>
                                </div>
                                <div class="col-2">
                                    {{$basket_product->price}} TL
                                </div>
                                <div class="col-1">
                                    <a href="" class="btn btn-danger"
                                       id="btn_remove_product_from_basket">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer d-flex justify-content-end">

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{"/js/product.js"}}"></script>

@endsection
