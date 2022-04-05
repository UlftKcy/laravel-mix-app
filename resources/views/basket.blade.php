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
            <form id="form_basket">
                <div class="card-body p-5 bg-light bg-gradient">
                    @if($basket_products->isNotEmpty())
                    @foreach($basket_products as $basket_product)
                        <div class="row mb-5" id="product_row_{{$basket_product->id}}">
                            <div class="card">
                                <div class="card-body row">
                                    <div class="col-6">
                                        {{$basket_product->name}}
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"
                                             style="width:150px;">
                                            <button
                                                class="btn btn-sm btn-outline-secondary bootstrap-touchspin-down rounded-0 btn-basket-decrease"
                                                type="button" data-value="{{$basket_product->id}}">-
                                            </button>
                                            <input type="text" name="product_count_in_basket"
                                                   class="form-control text-center border border-dark product_quantity_in_basket"
                                                   value="{{$basket_product->quantity}}" disabled/>
                                            <button
                                                class="btn btn-sm btn-outline-secondary bootstrap-touchspin-up rounded-0 btn-basket-increase"
                                                type="button" data-value="{{$basket_product->id}}">+
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <span id="total_row_price-{{$basket_product->id}}">{{$basket_product->total_row_price}} TL</span>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-danger"
                                           id="btn_remove_product_from_basket" data-value="{{$basket_product->id}}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="d-flex justify-content-center">
                            <img src="{{"/product-images/emptybasket.png"}}" alt="">
                        </div>
                    @endif
                </div>
                <div class="card-footer p-0">
                    @if($basket_products->isNotEmpty())
                    <div class="row d-flex justify-content-end">
                        <div class="col-4 p-3">
                            <h6 class="fw-bolder text-dark mb-3">Order Summary</h6>
                            <div class="row mb-2">
                                <div class="col-6"><span class="fw-bold text-muted">Total Quantity</span></div>
                                <div class="col-6"><span class="fw-bold" id="total_in_basket_quantity">{{$total_in_basket_quantity}} adet</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><span class="fw-bold text-muted">Total Price</span></div>
                                <div class="col-6"><span class="fw-bold" id="total_in_basket_price">{{$total_in_basket_price}} TL</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success mt-3" id="btn_save_basket">Proceed to Checkout</button>
                            </div>
                        </div>
                    </div>
                    @else
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{"/js/product.js"}}"></script>
@endsection
