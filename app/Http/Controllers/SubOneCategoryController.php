<?php

namespace App\Http\Controllers;

use App\Models\SubOneCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            "main_category_id" => "required",
            "category_name" => "required"
        ]);
        dd($request);
        if ($validator->fails()) {
            return response()->json(["status" => "success", "message" => "An error occurred"]);
        }

        DB::beginTransaction();
        try {
            $subOneCategories = new SubOneCategory();
            $subOneCategories->main_category_id = $request->main_category_id;
            $subOneCategories->name = $request->category_name;
            $subOneCategories->save();

            $url = route('index');

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
}
