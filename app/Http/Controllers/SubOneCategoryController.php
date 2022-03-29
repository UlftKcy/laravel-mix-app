<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\SubOneCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubOneCategoryController extends Controller
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
            "main_category" => "required",
            "category_name" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "success", "message" => "An error occurred"]);
        }

        DB::beginTransaction();
        try {
            $subOneCategories = new SubOneCategory();
            $subOneCategories->main_category_id = $request->main_category;
            $subOneCategories->name = $request->category_name;
            $subOneCategories->uuid = Str::uuid();
            $subOneCategories->save();

            $url = route('index');

            DB::commit();

            return response()->json(["status" => "success", "message" => "created successfully", "url" => $url]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SubOneCategory $subOneCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubOneCategory $subOneCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\SubOneCategory $subOneCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubOneCategory $subOneCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubOneCategory $subOneCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubOneCategory $subOneCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SubOneCategory $subOneCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubOneCategory $subOneCategory)
    {
        //
    }

    /**
     * Fetch main category
     */

    public function fetchMainCategory(Request $request): JsonResponse
    {
        try {
            /** @var MainCategory $main_categories */
            $main_categories = MainCategory::all();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "main_categories" => $main_categories
            ]]);

        } catch (\Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }
    }
}
