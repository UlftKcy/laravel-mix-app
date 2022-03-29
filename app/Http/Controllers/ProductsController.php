<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\Products;
use App\Models\SubOneCategory;
use App\Models\SubTwoCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProductsController extends Controller
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "add_product_sub_two_category" => "required",
            "product_name" => "required",
            "product_price" => "required",
            "product_quantity" => "required",
            "product_description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "an error occurred"]);
        }

        DB::beginTransaction();
        try {
            $product = new Products();
            $product->name = $request->product_name;
            $product->uuid = Str::uuid();
            $product->sub_two_category_id = $request->add_product_sub_two_category;
            $product->price = $request->product_price;
            $product->quantity_in_stock = $request->product_quantity;
            $product->description = $request->product_description;
            $product->save();
            Alert::success('Congrats', 'You\'ve Successfully Added');
            $url = route("index");

            DB::commit();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "url" => $url]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }

    /**
     * Fetch main categories
     */

    public function fetchMainCategories(Request $request): JsonResponse
    {
        try {
            /** @var MainCategory $main_categories */
            $main_categories = MainCategory::all();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "main_categories" => $main_categories,
            ]]);


        } catch (\Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }
    }

    /**
     * Fetch sub-one category
     */

    public function fetchSubOneCategories(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "add_product_main_category_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "an error occurred"]);
        }
        try {
            /** @var SubOneCategory $sub_one_categories */
            $sub_one_categories = SubOneCategory::query()
                ->select("sub_one_categories.id as id", "sub_one_categories.name as name")
                ->join("main_categories", "main_categories.id", "=", "main_category_id")
                ->where("main_categories.id", "=", $request->add_product_main_category_id)
                ->get();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "sub_one_categories" => $sub_one_categories,
            ]]);


        } catch (\Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }
    }

    /**
     * Fetch sub-two category
     */

    public function fetchSubTwoCategories(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "add_product_sub_one_category_id" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "an error occurred"]);
        }
        try {
            /** @var SubTwoCategory $sub_two_categories */
            $sub_two_categories = SubTwoCategory::query()
                ->select("sub_two_categories.id as id", "sub_two_categories.name as name")
                ->join("sub_one_categories", "sub_one_categories.id", "=", "sub_one_category_id")
                ->where("sub_one_categories.id", "=", $request->add_product_sub_one_category_id)
                ->get();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "sub_two_categories" => $sub_two_categories,
            ]]);


        } catch (\Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }
    }
}
