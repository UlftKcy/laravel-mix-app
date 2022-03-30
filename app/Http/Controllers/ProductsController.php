<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\SubOneCategory;
use App\Models\SubTwoCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        /*  dd($request->all());*/
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

            if ($request->hasFile("product_image")) {
                $product_image = $request->file("product_image");

                $imagePath = $product_image->getClientOriginalName();
                Storage::disk("product_images")->put($imagePath, $product_image->getContent());

                $product_image_file = new ProductImage();
                $product_image_file->name = $product_image->getClientOriginalName();
                $product_image_file->uuid = Str::uuid();
                $product_image_file->product_id = $product->id;
                $product_image_file->path = $imagePath;
                $product_image_file->size = $product_image->getSize();
                $product_image_file->ext = $product_image->getClientOriginalExtension();
                $product_image_file->save();
            }

            $url = route("index");


            DB::commit();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "url" => $url]);

        } catch (\Exception $exception) {
            DB::rollback();
            /*  dd($exception->getMessage());*/
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
    public function edit(Products $products, $id)
    {
        $product = Products::where("id", $id)->first();
        $product_sub_two_category = SubTwoCategory::where("id", $product->sub_two_category_id)->first();
        $product_sub_one_category = SubOneCategory::where("id", $product_sub_two_category->sub_one_category_id)->first();
        $product_main_category = MainCategory::where("id", $product_sub_one_category->main_category_id)->first();

        return view('edit', compact('product', 'product_sub_two_category', 'product_sub_one_category', 'product_main_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            "product_id" => "required",
            "edit_product_name" => "required",
            "edit_product_price" => "required",
            "edit_product_quantity" => "required",
            "edit_product_description" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "an error occurred"]);
        }

        DB::beginTransaction();
        try {
            /**@var Products $product */
            $product = Products::where("id", $request->product_id)->first();

            $product->name = $request->edit_product_name;
            $product->price = $request->edit_product_price;
            $product->quantity_in_stock = $request->edit_product_quantity;
            $product->description = $request->edit_product_description;
            $product->save();
            Alert::success('Congrats', 'You\'ve Successfully Updated Product');
            $url = route("index");

            DB::commit();
            return response()->json(["status" => "success", "message" => "successfully updated product", "url" => $url]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(["status" => "error", "message" => "an error occurred while updating"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::where("id", $id)->first();
        if ($product != null) {
            $product->delete();
            return redirect()->route('index');
        }
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
