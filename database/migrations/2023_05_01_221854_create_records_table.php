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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone_number');
            $table->string('gender');
            $table->string('age');
// Address
            $table->string('region');
            $table->string('district');
            $table->string('ward');
            $table->string('village');
            $table->string('sub_village');
            $table->string('amcos');
            $table->string('amcos_physical_location');

            $table->string('collector_name');
            $table->string('collector_phone_number');
            $table->string('wheight');
            $table->string('price_per_kg');




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
