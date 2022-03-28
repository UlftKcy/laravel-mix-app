<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MainCategoryController extends Controller
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
            "category_name" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "warning", "message" => "An error occurred"]);
        }

        DB::beginTransaction();
        try {

            $main_categories = new MainCategory();
            $main_categories->name = $request->category_name;
            $main_categories->uuid = Str::uuid();
            $main_categories->save();

            $url = route('index');

            DB::commit();
            return response()->json(["status" => "success", "message" => "created category successfully", "url" => $url]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(["status" => "error", "message" => "An error occurred"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MainCategory $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\MainCategory $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MainCategory $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MainCategory $mainCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\MainCategory $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MainCategory $mainCategory)
    {
        //
    }
}
