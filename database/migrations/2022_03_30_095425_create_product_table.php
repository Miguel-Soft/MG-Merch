<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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

            // MG BBQ

            // $table->string('name');
            // $table->string('info');
            // $table->double('price', 4, 2);
            // $table->boolean('multiple');
            // $table->boolean('show');
            // $table->integer('startval')->default('0');

            // MG Merch

            $table->string('name');
            $table->string('info');
            $table->double('price', 5, 2);
            $table->json('photo');
            $table->boolean('custom_text');
            $table->boolean('show')->default(true);
            $table->string('data_json');

            $table->timestamps();
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
};
