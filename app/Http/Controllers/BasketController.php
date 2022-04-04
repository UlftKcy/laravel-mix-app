<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required",
            "product_quantity" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "An error occurred"]);
        }

        DB::beginTransaction();

        try {
            if ($request->product_quantity == 0){
                return response()->json(["status" => "success", "message" => "Quantity must be more than 1"]);
            }
            $product = new Basket();
            $product->uuid = Str::uuid();
            $product->product_id = $request->product_id;
            $product->quantity = $request->product_quantity;
           /* $product->save();*/

            /** @var Products $product_in_basket */
            $product_in_basket = Products::query()
                ->select("products.name as name", "products.description as description")
                ->addSelect("products.price as price", "products.quantity_in_stock as quantity_in_stock", "products.id as id")
                ->leftJoin("baskets", "baskets.product_id", "=", "products.id")
                ->where("products.id", $request->product_id)
                ->first();

            DB::commit();

            return response()->json(["status" => "success", "message" => "successfully added to basket", "data" => ["product_in_basket" => $product_in_basket]]);


        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Basket $basket
     * @return \Illuminate\Http\Response
     */
    public function show(Basket $basket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Basket $basket
     * @return \Illuminate\Http\Response
     */
    public function edit(Basket $basket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Basket $basket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Basket $basket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Basket $basket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Basket $basket)
    {
        //
    }
}
