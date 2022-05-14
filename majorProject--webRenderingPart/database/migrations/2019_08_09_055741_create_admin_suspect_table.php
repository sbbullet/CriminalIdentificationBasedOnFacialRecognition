<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSuspectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_suspect', function (Blueprint $table) {
            $table->integer('admin_id')->unsigned();
            $table->integer('suspect_id')->unsigned();
            $table->primary(['admin_id', 'suspect_id']);
            $table->integer('no_of_detections')->unsigned();
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
        Schema::dropIfExists('admin_suspect');
    }
}
