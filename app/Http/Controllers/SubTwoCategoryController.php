<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\SubOneCategory;
use App\Models\SubTwoCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class SubTwoCategoryController extends Controller
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
            "sub_one_category" => "required",
            "category_name" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => "success", "message" => "An error occurred"]);
        }
        DB::beginTransaction();
        try {

            $sub_two_categories = new SubTwoCategory();
            $sub_two_categories->sub_one_category_id = $request->sub_one_category;
            $sub_two_categories->name = $request->category_name;
            $sub_two_categories->uuid = Str::uuid();
            $sub_two_categories->save();

            $url = route('index');

            DB::commit();
            return response()->json(["status" => "success", "message" => "Successfully added", "url" => $url]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SubTwoCategory $subTwoCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubTwoCategory $subTwoCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\SubTwoCategory $subTwoCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubTwoCategory $subTwoCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubTwoCategory $subTwoCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubTwoCategory $subTwoCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SubTwoCategory $subTwoCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubTwoCategory $subTwoCategory)
    {
        //
    }

    /**
     * Fetch sub-one category
     */

    public function fetchSubOneCategory(Request $request): JsonResponse
    {
        try {
            /** @var SubOneCategory $sub_one_categories */
            $sub_one_categories = SubOneCategory::all();

            return \response()->json(["status" => "success", "message" => "İşlem başarıyla tamamlandı.", "data" => [
                "sub_one_categories" => $sub_one_categories
            ]]);

        } catch (\Exception $exception) {
            return response()->json(["status" => "error", "message" => $exception->getMessage()]);
        }
    }
}
