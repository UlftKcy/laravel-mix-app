<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->unsignedInteger('quantity_in_stock');
            $table->bigInteger('sub_two_category_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sub_two_category_id')->references('id')->on('sub_two_categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
