<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLonToLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // SQLite has trouble adding new columns unless they're nullable,
        // so just drop the table and rebuild it with the new columns
        Schema::dropIfExists('locations');

        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->decimal('lat', 9, 7);
            $table->decimal('lon', 9, 7);
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
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lon');
        });
    }
}
