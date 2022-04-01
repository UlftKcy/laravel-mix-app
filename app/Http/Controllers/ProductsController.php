<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\SubOneCategory;
use App\Models\SubTwoCategory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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

            if ($request->hasFile("product_image")) {
                $product_image = $request->file("product_image");

                $imagePath = $product_image->getClientOriginalName();
                Storage::disk("product_images")->put($imagePath, $product_image->getContent());

                $this->ProductImage($product_image, $product, $imagePath);
            }

            /** @var  $product_query */
            $product_query = Products::query()
                ->select("products.name as name", "products.description as description")
                ->addSelect("products.price as price", "products.id as id")
                ->addSelect("product_images.path as path")
                ->leftJoin("product_images", "product_images.product_id", "=", "products.id")
                ->where("products.id", "=", $product->id)
                ->first();

            DB::commit();

            return response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "product_item" => $product_query
            ]]);

        } catch (Exception $exception) {
            DB::rollback();
            /*  dd($exception->getMessage());*/
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Products $products
     * @return Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Products $products
     * @param $id
     * @return Application|Factory|View
     */
    public function edit(Products $products, $id)
    {
        /** @var Products $product */
        $product = Products::query()->where("id", $id)->first();

        /** @var SubTwoCategory $product_sub_two_category */
        $product_sub_two_category = SubTwoCategory::query()->where("id", $product->sub_two_category_id)->first();

        /** @var SubOneCategory $product_sub_one_category */
        $product_sub_one_category = SubOneCategory::query()->where("id", $product_sub_two_category->sub_one_category_id)->first();

        /** @var MainCategory $product_main_category */
        $product_main_category = MainCategory::query()->where("id", $product_sub_one_category->main_category_id)->first();

        /** @var ProductImage $product_image */
        $product_image = ProductImage::query()->where("product_id", $id)->first();

        return view('edit', compact('product', 'product_sub_two_category', 'product_sub_one_category', 'product_main_category', 'product_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Products $products
     * @return JsonResponse
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
            $product = Products::query()->where("id", $request->product_id)->first();

            $product->name = $request->edit_product_name;
            $product->price = $request->edit_product_price;
            $product->quantity_in_stock = $request->edit_product_quantity;
            $product->description = $request->edit_product_description;
            $product->update();

            if ($request->hasFile("product_image")) {

                /** @var ProductImage $product_image_query */
                $product_image_query = ProductImage::query()->where("product_id", "=", $product->id)->first();

                if ($product_image_query !== null) {
                    File::delete($product_image_query->path);
                    $product_image_query->delete();
                }

                $product_image = $request->file("product_image");

                $imagePath = $product_image->getClientOriginalName();

                Storage::disk("product_images")->put($imagePath, $product_image->getContent());

                $this->ProductImage($product_image, $product, $imagePath);
            }
            $url = route("index");

            DB::commit();
            return response()->json(["status" => "success", "message" => "successfully updated product", "url" => $url]);
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json(["status" => "error", "message" => "an error occurred while updating"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Products $products
     * @return Response
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

            return response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "main_categories" => $main_categories,
            ]]);


        } catch (Exception $exception) {
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

            return response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "sub_one_categories" => $sub_one_categories,
            ]]);


        } catch (Exception $exception) {
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

            return response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "sub_two_categories" => $sub_two_categories,
            ]]);


        } catch (Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }
    }

    /**
     * @param $product_image
     * @param Products $product
     * @param string $imagePath
     * @return void
     */
    public function ProductImage($product_image, Products $product, string $imagePath): void
    {
        $product_image_file = new ProductImage();
        $product_image_file->name = $product_image->getClientOriginalName();
        $product_image_file->uuid = Str::uuid();
        $product_image_file->product_id = $product->id;
        $product_image_file->path = $imagePath;
        $product_image_file->size = $product_image->getSize();
        $product_image_file->ext = $product_image->getClientOriginalExtension();
        $product_image_file->save();
    }
}
