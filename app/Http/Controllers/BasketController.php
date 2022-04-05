<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Products;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psy\Util\Json;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        /** @var Products $basket_products */

        $basket_products = Products::query()
            ->select("products.name as name", "products.description as description")
            ->addSelect("products.price as price", "products.id as id", "products.quantity_in_stock as quantity_in_stock")
            ->addSelect("baskets.quantity as quantity")
            ->leftJoin("baskets", "baskets.product_id", "=", "products.id")
            ->whereNull("baskets.deleted_at")
            ->get();

        $total_in_basket_quantity = 0;
        $total_in_basket_price = 0;
        foreach ($basket_products as $basket_product) {
            $product_quantity = $basket_product->quantity;
            $product_price = $basket_product->price;
            $basket_product->total_row_price = (int)$product_quantity * (int)$product_price;
            $total_in_basket_quantity = $total_in_basket_quantity + (int)$product_quantity;
            $total_in_basket_price = $total_in_basket_price + (int)$basket_product->total_row_price;
        }

        return view('basket', compact('basket_products', 'total_in_basket_quantity', 'total_in_basket_price'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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

            if ($request->product_quantity == 0) {
                return response()->json(["status" => "warning", "message" => "Quantity must be more than 1"]);
            }

            /** @var Basket $selected_product */
            $selected_product = Basket::query()->where("product_id", $request->product_id)->first();

            if ($selected_product !== null) {
                $total_quantity = $selected_product->quantity + $request->product_quantity;
                $selected_product->quantity = $total_quantity;
                $selected_product->update();
            } else {
                $product = new Basket();
                $product->uuid = Str::uuid();
                $product->product_id = $request->product_id;
                $product->quantity = $request->product_quantity;
                $product->save();
            }

            DB::commit();

            return response()->json(["status" => "success", "message" => "successfully added to basket"]);


        } catch (Exception $exception) {
            DB::rollBack();
            /*dd($exception->getMessage());*/
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Basket $basket
     * @return Response
     */
    public function show(Basket $basket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Basket $basket
     * @return Response
     */
    public function edit(Basket $basket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Basket $basket
     * @return Response
     */
    public function update(Request $request, Basket $basket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $product = Basket::query()->where('product_id', $request->product_id)->first();

        $url = route('basket');

        if ($product != null) {
            $product->delete();
            return response()->json(["status" => "success", "message" => "Product removed successfully", "url" => $url]);
        }

    }

    /**
     * Decrease product count from basket.
     *
     * @param Basket $basket
     * @return Response
     */
    public function decreaseProductCountInBasket(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "an error occurred"]);
        }
        try {

            /** @var Products $product */
            $product = Products::query()
                ->select("products.id as id", "products.price as price", "products.quantity_in_stock as quantity_in_stock")
                ->where("products.id", "=", $request->product_id)
                ->first();

            /** @var Basket $selected_product */
            $selected_product = Basket::query()->where("product_id", $request->product_id)->first();
            if ($selected_product !== null) {
                $selected_product_quantity = $selected_product->quantity - 1;
                $selected_product->quantity = $selected_product_quantity;
                $selected_product->update();
            }

            if ($selected_product->quantity == 0 && $selected_product !== null) {
                $selected_product->delete();
            }

            return response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "product" => $product,
                "selected_product" => $selected_product
            ]]);

        } catch (Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }

    }

    /**
     * Decrease product count from basket.
     *
     * @param Basket $basket
     * @return Response
     */
    public function increaseProductCountInBasket(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "an error occurred"]);
        }
        try {

            /** @var Products $product */
            $product = Products::query()
                ->select("products.id as id", "products.price as price", "products.quantity_in_stock as quantity_in_stock")
                ->where("products.id", "=", $request->product_id)
                ->first();

            /** @var Basket $selected_product */
            $selected_product = Basket::query()->where("product_id", $request->product_id)->first();
            if ($selected_product !== null) {
                $selected_product_quantity = $selected_product->quantity + 1;
                $selected_product->quantity = $selected_product_quantity;
                $selected_product->update();
            }

            return response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "product" => $product,
                "selected_product" => $selected_product
            ]]);
        } catch (Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }

    }
}
