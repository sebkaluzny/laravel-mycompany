<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetElementsSizesToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elements', function ($table) {
            $table->integer('thickness')->change();
            $table->integer('width')->change();
            $table->integer('length')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elements', function ($table) {
            $table->float('thickness')->default(0)->change();
            $table->float('width')->default(0)->change();
            $table->float('length')->default(0)->change();
        });
    }
}
