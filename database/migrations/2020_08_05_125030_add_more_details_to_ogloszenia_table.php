<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreDetailsToOgloszeniaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ogloszenia', function (Blueprint $table) {
            $table->integer('additional_costs')->nullable();
            $table->string('rooms')->nullable();
            $table->string('floor')->nullable();
            $table->string('condition')->nullable();
            $table->string('heating')->nullable();
            $table->integer('year_of_construction')->nullable();
            $table->text('equipment')->nullable();
            $table->text('additional_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ogloszenia', function (Blueprint $table) {
            $table->dropColumn('additional_costs');
            $table->dropColumn('rooms');
            $table->dropColumn('floor');
            $table->dropColumn('condition');
            $table->dropColumn('heating');
            $table->dropColumn('year_of_construction');
            $table->dropColumn('equipment');
            $table->dropColumn('additional_info');
        });
    }
}
