<?php

namespace App\Http\Controllers;

use App\Models\CategoryTypes;
use App\Models\MainCategory;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        /** @var CategoryTypes $category_types */
        $category_types = CategoryTypes::all();

        /** @var  $products */
        $products = Products::query()
            ->select("products.name as name", "products.description as description")
            ->addSelect("products.price as price", "products.id as id","products.uuid as uuid")
            ->addSelect("product_images.path as path")
            ->leftJoin("product_images", "product_images.product_id", "=", "products.id")
            ->whereNull("product_images.deleted_at")
            ->get();


        return view('dashboard', compact('category_types', 'products'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
