<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementsExportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elements_export', function (Blueprint $table) {
            $table->increments('id');

            $table->string('hash');
//            $table->string('type');
            $table->text('export_data');

            $table->text('data');

            $table->index('hash');
//            $table->index('type');
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
        Schema::dropIfExists('elements_export');
    }
}
