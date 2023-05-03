<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            // Address
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('ward')->nullable();
            $table->string('village')->nullable();
            $table->string('sub_village')->nullable();
            $table->string('amcos')->nullable();
            $table->string('amcos_physical_location')->nullable();

            $table->string('collector_name')->nullable();
            $table->string('collector_phone_number')->nullable();
            $table->string('wheight')->nullable();
            $table->string('price_per_kg')->nullable();




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
        Schema::dropIfExists('records');
    }
};