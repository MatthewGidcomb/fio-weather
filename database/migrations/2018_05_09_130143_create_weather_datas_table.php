<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->string('conditions')->nullable();
            $table->string('icon')->nullable();
            $table->decimal('temp', 5, 2)->nullable();
            $table->decimal('humidity', 3, 1)->nullable();
            $table->decimal('pressure', 4, 1)->nullable();
            $table->decimal('cloud_cover', 3, 1)->nullable();
            $table->decimal('wind_speed', 4, 1)->nullable();
            $table->decimal('wind_gust', 4, 1)->nullable();
            $table->string('wind_dir')->nullable();

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
        Schema::dropIfExists('weather_datas');
    }
}
